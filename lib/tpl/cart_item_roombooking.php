<?php
$room							= $this->get_root()->get_instances()['sv_bb_dashboard']->query->rooms->get_by_wc_product_id($_product->get_ID());
if($room){
	$location						= $room->get_location();
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
		</div>
		<!-- date ------------------------------------------------------ -->
		<div class="row cart-date d-flex align-items-center">
			<div class="col-xs-12 col-sm-6">
				<?php _e('Datum','sv_bb_woo_cart_sidebar');?>
			</div>
			<div class="col-xs-12 col-sm-6 text-right cart-value">
				<?php
				$date = new DateTime($cart_item['_sv_bb_dashboard_date']);
                echo date_i18n('l, j. F Y', $date->getTimestamp());
                ?>
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
					data-id="<?php echo $room->get_ID(); ?>"
					data-title="<?php echo $room->get_title(); ?>"
					data-product="<?php echo $room->get_title(); ?>"
					data-variant="<?php echo $cart_item['data']->get_formatted_name(); ?>"
					data-price="<?php echo $cart_item['data']->get_price(); ?>"
					data-quantity="<?php echo $cart_item['quantity']; ?>"
					class="cart-action-remove font-size-sm text-grey text-uppercase btn btn-mute btn-sm no-shadow" title="<?php _e('Produkt entfernen','sv_bb_woo_cart_sidebar');?>"><?php _e('Produkt entfernen','sv_bb_woo_cart_sidebar');?></button>
			</div>
		</div>
	</li>
<?php 	} ?>