<?php
	$class		= '';

	if(is_user_logged_in() && is_cart()) {
		$class 	= 'user-cart';
	} else {
		$class 	= 'mt-0';
	}
?>
<!-- billing --------------------------------------- -->
<li id="billing" class="sv_checkout-nav-body-item active pb-5">	
	<div class="row pb-5">
		<div class="col-xs-12 col-sm-12 col-md-7 position-static gform_no_header">
			<label class="font-weight-bold mb-4"><?php _e('Rechnungsadresse','sv_woocommerce'); ?></label>
			<?php echo do_shortcode('[gravityform id="user_update_checkout" ajax="false" update]'); ?>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-5 sv_woo_cart_sidebar_content pb-4 <?php echo $class; ?>">
			<?php echo do_shortcode('[sv_woocommerce_custom template="cart"]'); ?>
		</div>
	</div>
</li>