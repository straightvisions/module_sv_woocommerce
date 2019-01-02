<div class="row m-0 p-0 cart-subtotal">
	<div class="col-6"><?php _e('Subtotal', 'woocommerce'); ?></div>
	<div class="col-6"><?php echo WC()->cart->get_cart_subtotal(); ?></div>
</div>
<?php
			foreach(WC()->cart->get_coupons() as $code => $coupon){
				ob_start();
				wc_cart_totals_coupon_html($coupon);
				$html			= ob_get_contents();
				ob_end_clean();
				echo '
				<div class="row m-0 p-0 cart-discount coupon-'.esc_attr(sanitize_title($code)).'">
					<div class="col-6">'.wc_cart_totals_coupon_label($coupon, false).'</div>
					<div class="col-6">'.$html.'</div>
				</div>
				';
			}
			if(WC()->cart->needs_shipping() && WC()->cart->show_shipping()){
				do_action('woocommerce_review_order_before_shipping');
				wc_cart_totals_shipping_html();
				do_action('woocommerce_review_order_after_shipping');
			}
			foreach(WC()->cart->get_fees() as $fee){
				ob_start();
				wc_cart_totals_fee_html($fee);
				$html			= ob_get_contents();
				ob_end_clean();
				echo '
				<div class="row m-0 p-0 fee">
					<div class="col-6">'.esc_html($fee->name).'</div>
					<div class="col-6">'.$html.'</div>
				</div>
				';
			}
			if(wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart){
				if('itemized' === get_option('woocommerce_tax_total_display')){
					foreach(WC()->cart->get_tax_totals() as $code => $tax){
					echo '
					<div class="row m-0 p-0 tax-rate tax-rate-'.sanitize_title($code).' row">
						<div class="col-6">'.esc_html($tax->label).'</div>
						<div class="col-6">'.wp_kses_post($tax->formatted_amount).'</div>
					</div>
					';
					}
				}else{
					ob_start();
					wc_cart_totals_taxes_total_html();
					$html			= ob_get_contents();
					ob_end_clean();
					echo '
					<div class="row m-0 p-0 tax-total">
						<div class="col-6">'.esc_html(WC()->countries->tax_or_vat()).'</div>
						<div class="col-6">'.$html.'</div>
					</div>
					';
				}
			}

			ob_start();
			wc_cart_totals_order_total_html();
			$html			= ob_get_contents();
			ob_end_clean();
			echo do_shortcode('[sv_woocommerce template="coupon"]');
			echo '
					<div class="row m-0 p-0 py-4 mt-4 order-total woocommerce-mini-cart__total">
						<div class="col-6">'.__('Total', 'woocommerce').'</div>
						<div class="col-6">'.$html.'</div>
					</div>
			';
?>