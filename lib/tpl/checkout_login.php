<!-- login ----------------------------------------- -->
<li id="registration" class="sv_checkout-nav-body-item active">
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-7">
		<label class="font-weight-bold mb-4"><?php _e('Ich bin bereits Brainbirds Kunde','sv_woocommerce'); ?></label>
		<?php echo do_shortcode('[login-with-ajax registration="0" redirect="'.wc_get_cart_url().'"]'); ?>

		<label class="font-weight-bold mb-4 mt-5"><?php _e('Kennwort vergessen?','sv_woocommerce'); ?></label>
		<?php echo do_shortcode('[sv_password_lost]'); ?>

		<label class="font-weight-bold mb-4 mt-5"><?php _e('Ich habe noch kein Benutzerkonto','sv_woocommerce'); ?></label>
		<?php //echo do_shortcode('[sv_registration]'); ?>
		<?php echo do_shortcode('[gravityform ID="user_registration_minimal" ajax="true"]'); ?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-5 sv_woo_cart_sidebar_content coupon">
		<?php echo do_shortcode('[sv_woocommerce template="cart"]'); ?>
	</div>
</div>
</li>