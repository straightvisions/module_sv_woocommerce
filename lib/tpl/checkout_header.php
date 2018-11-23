<style>
	#gform_wrapper_1000{display:block !important;} /* hotfix */
</style>
<?php //echo do_shortcode('[sv_woocommerce_custom template="coupon_form"]'); ?>
<div id="sv_checkout">
	<div id="sv_checkout_header" class="row">
		<div class="col-xs-12 col-sm-12">
			<h1 class="h2"><?php _e('Buchung','woocommerce'); ?></h1>
		</div>
		<div class="col-xs-12 col-sm-12">
			<ul class="sv_checkout-nav-tabs">
				<?php if(!is_user_logged_in()){ ?>
				<li class="sv_checkout-nav-item active" data-target="registration"><?php _e('Anmeldung','woocommerce');?></li>
				<li class="sv_checkout-nav-item disabled" data-target="billing"><?php _e('Rechnungsdetails','woocommerce');?></li>
				<?php } if(is_user_logged_in() && is_cart()) { ?>
					<li class="sv_checkout-nav-item active" data-target="billing"><?php _e('Rechnungsdetails','woocommerce');?></li>
				<?php } else if(is_user_logged_in() && is_checkout()) { ?>
					<a href="/cart/"><li class="sv_checkout-nav-item disabled" data-target="billing"><?php _e('Rechnungsdetails','woocommerce');?></li></a>
				<?php } ?>

				<li class="sv_checkout-nav-item <?php echo (is_checkout() && !is_wc_endpoint_url( 'order-received' )) ? 'active' : 'disabled';?>" data-target="summary"><?php _e('Überprüfung','woocommerce');?></li>
				<li class="sv_checkout-nav-item <?php echo (is_wc_endpoint_url( 'order-received' )) ? 'active' : 'disabled';?>" data-target="thankyou"><?php _e('Buchung','woocommerce');?></li>
			</ul>
		</div>
	</div>
	<!-- CONTENT ----------------------------------------------------------- -->
	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<div id="sv_checkout_body">
				<p class="text-center">Sie benötigen Unterstützung oder haben Fragen? Rufen Sie uns einfach an: <strong>+49 / 89 / 413 29 75 - 0</strong></p>
				<p>&nbsp;</p>
				<ul class="sv_checkout-nav-tabs-body">
<?php
if(!is_user_logged_in()){
	echo do_shortcode('[sv_woocommerce_custom template="checkout_login"]');
}elseif(is_cart()){
	echo do_shortcode('[sv_woocommerce_custom template="checkout_cart"]');
}elseif(is_wc_endpoint_url('order-received')){
	echo do_shortcode('[sv_woocommerce_custom template="checkout_thankyou"]');
}elseif(is_checkout()){
	echo do_shortcode('[sv_woocommerce_custom template="checkout_review"]');
}else{
	
}
?>