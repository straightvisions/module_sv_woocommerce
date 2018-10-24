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
	<li name="<?php echo $cart_item_key;?>" class="woocommerce-cart-item">
		<div class="row grid-small d-flex align-items-center cart-item-name">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
				<div class="bg-yellow padding-h-xs padding-v-xs font-weight-bold text-uppercase">
					<?php echo $_product->get_title(); ?>
				</div>
			</div>
			<?php
			$images = $product->get_image_ids();
			if(!empty($images)) {
				?>
				<div class="col-md-6 col-lg-7">
					<div class="row m-0 d-none d-md-flex">
						<?php
						$x			= 0;
						foreach($images as $image) {
							if($x > 2) { break; }
							$image_properties               = wp_get_attachment_image_src($image, array(100,100));
                        ?>
							<div class="col-4">
								<img src="<?php echo $image_properties[0]; ?>" width="<?php echo $image_properties[1]; ?>" height="<?php echo $image_properties[2]; ?>" alt="Product image" class="modal-cart-image">
							</div>
                        <?php $x++; } ?>
					</div>
				</div>
			<?php } ?>
		</div>
		<!-- slots ----------------------------------------------------- -->
		<div class="row cart-quantity d-flex align-items-center">
			<div class="col-xs-12 col-sm-6">
				<?php _e('Seminarplätze','sv_bb_woo_cart_sidebar');?>
			</div>
			<div class="col-xs-12 col-sm-6 text-right cart-value">
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
		</div>
		<!-- city ------------------------------------------------------ -->
		<div class="row cart-city d-flex align-items-center">
			<div class="col-xs-12 col-sm-6">
				<?php _e('Stadt','sv_bb_woo_cart_sidebar');?>
			</div>
			<div class="col-xs-12 col-sm-6 text-right cart-value">
				<?php echo $seminar->get_location()->get_bb_meta('city'); ?>
			</div>
		</div>
		<!-- date ------------------------------------------------------ -->
		<div class="row cart-date d-flex align-items-center">
			<div class="col-xs-12 col-sm-6">
				<?php _e('Datum','sv_bb_woo_cart_sidebar');?>
			</div>
			<div class="col-xs-12 col-sm-6 text-right cart-value">
				<?php echo $seminar->get_date_condensed(); ?>
			</div>
		</div>
		<!-- total ----------------------------------------------------- -->
		<div class="row cart-total font-weight-bold d-flex align-items-center">
			<div class="col-xs-12 col-sm-6">
				<?php _e('Summe','sv_bb_woo_cart_sidebar');?>
			</div>
			<div class="col-xs-12 col-sm-6 text-right cart-value">
				<?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']),$cart_item, $cart_item_key); ?>
			</div>
		</div>
		<!-- actions ----------------------------------------------------- -->
		<div class="row cart-actions-sidebar">
			<div class="col-xs-12 col-sm-12 text-right">
				<button
						data-id="<?php echo $seminar->get_bb_meta('variation_id'); ?>"
						data-title="<?php echo $seminar->get_title(); ?>"
						data-product="<?php echo $product->get_title(); ?>"
						data-variant="<?php echo $location->get_bb_meta('city'); ?> - <?php echo $seminar->get_bb_meta('day_1'); ?>"
						data-price="<?php echo $cart_item['data']->get_price(); ?>"
						data-quantity="<?php echo $cart_item['quantity']; ?>"
						class="cart-action-remove font-size-sm text-grey text-uppercase btn btn-mute btn-sm no-shadow" title="<?php _e('Entfernen','sv_bb_woo_cart_sidebar');?>"><?php _e('Entfernen','sv_bb_woo_cart_sidebar');?></button>
			</div>
		</div>
	</li>
<?php 	} ?>