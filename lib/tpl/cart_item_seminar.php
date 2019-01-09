<?php
$seminar						= $this->get_root()->get_instances()['sv_bb_dashboard']->query->seminars->get_by_variation_id($cart_item['variation_id']);
if($seminar){
	$location						= $seminar->get_location();
	$trainers						= $seminar->get_trainer();
	$product						= $seminar->get_product();
	$product_name					= apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
	$thumbnail						= apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
	$product_price					= apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
	$product_permalink				= apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

// quantity
	if(!is_checkout() && $_product->is_sold_individually()){
		$product_quantity			= sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
	}elseif(!is_checkout()){
		$product_quantity			= woocommerce_quantity_input(array(
			'input_name'			=> 'cart['.$cart_item_key.'][qty]',
			'input_value'			=> $cart_item['quantity'],
			'max_value'				=> $_product->get_max_purchase_quantity(),
			'min_value'				=> '0',
		), $_product, false);
	}else{
		$product_quantity			= $cart_item['quantity'];
	}

// remove
	if(is_cart()){
		$remove						= apply_filters('woocommerce_cart_item_remove_link', sprintf(
			'<a href="%s" class="remove my-1 mx-5" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
			esc_url(wc_get_cart_remove_url($cart_item_key)),
			__('Remove this item', 'woocommerce'),
			esc_attr($_product->get_ID()),
			esc_attr($_product->get_sku())
		), $cart_item_key);
	}else{
		$remove						= '';
	}?>
	<li name="<?php echo $cart_item_key;?>" class="woocommerce-cart-item m-0">
		<div class="title bg-yellow font-weight-bold text-uppercase cart-item-name align-items-center d-flex p-4 mb-4">
			<?php echo $_product->get_title(); ?>
		</div>
		<!-- slots ----------------------------------------------------- -->
		<div class="row d-flex align-items-center m-0 p-0 cart-quantity">
			<div class="col-12 col-sm-6">
				<?php _e('Seminarplätze','sv_bb_woo_cart_sidebar');?>
			</div>
			<div class="col-12 col-sm-6 text-right cart-value">
				<select
						data-id="<?php echo $seminar->get_bb_meta('variation_id'); ?>"
						data-title="<?php echo $seminar->get_title(); ?>"
						data-product="<?php echo $product->get_title(); ?>"
						data-variant="<?php echo $location->get_bb_meta('city'); ?> - <?php echo $seminar->get_bb_meta('day_1'); ?>"
						data-price="<?php echo $cart_item['data']->get_price(); ?>"
						data-prev_val="<?php echo $cart_item['quantity']; ?>"
						name="quantity" class="custom-select woocommerce-qty-select">
					<?php
						$stock 		= $seminar->get_bb_meta('stock');

						if($stock > 4) {
							$stock 	= 4;
						}

						for($i = 1; $i <= $stock; $i++) {
							$selected = ($cart_item['quantity'] === $i) ? 'selected="selected"' : '';
							echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
						}
					?>
				</select>
			</div>
            <div class="col-12 text-grey font-size-sm pb-3">
	            (Seminarteilnehmer können<br>Sie nach der Buchung zuweisen.)
            </div>
		</div>
		<!-- city ------------------------------------------------------ -->
		<div class="row d-flex align-items-center m-0 p-0 cart-city">
			<div class="col-12 col-sm-6">
				<?php _e('Stadt','sv_bb_woo_cart_sidebar');?>
			</div>
			<div class="col-12 col-sm-6 text-right cart-value">
				<?php echo $seminar->get_location()->get_bb_meta('city'); ?>
			</div>
		</div>
		<!-- date ------------------------------------------------------ -->
		<div class="row d-flex align-items-center m-0 p-0 cart-date">
			<div class="col-12 col-sm-6">
				<?php _e('Datum','sv_bb_woo_cart_sidebar');?>
			</div>
			<div class="col-12 col-sm-6 text-right cart-value">
				<?php echo $seminar->get_date_condensed(); ?>
			</div>
		</div>
		<!-- total ----------------------------------------------------- -->
		<div class="row d-flex font-weight-bold align-items-center m-0 p-0 cart-total">
			<div class="col-12 col-sm-6">
				<?php _e('Summe','sv_bb_woo_cart_sidebar');?>
			</div>
			<div class="col-12 col-sm-6 text-right cart-value">
				<?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']),$cart_item, $cart_item_key); ?>
			</div>
		</div>
		<!-- actions ----------------------------------------------------- -->
		<div class="row cart-actions-sidebar">
			<div class="col-12 text-right">
				<button
						data-id="<?php echo $seminar->get_bb_meta('variation_id'); ?>"
						data-title="<?php echo $seminar->get_title(); ?>"
						data-product="<?php echo $product->get_title(); ?>"
						data-variant="<?php echo $location->get_bb_meta('city'); ?> - <?php echo $seminar->get_bb_meta('day_1'); ?>"
						data-price="<?php echo $cart_item['data']->get_price(); ?>"
						data-quantity="<?php echo $cart_item['quantity']; ?>"
						class="cart-action-remove font-size-sm text-grey text-uppercase btn btn-mute btn-sm no-shadow" title="<?php _e('Produkt entfernen','sv_bb_woo_cart_sidebar');?>"><?php _e('Produkt entfernen','sv_bb_woo_cart_sidebar');?></button>
			</div>
		</div>
	</li>
<?php 	} ?>