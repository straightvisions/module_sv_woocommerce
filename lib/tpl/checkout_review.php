<?php
	$checkout		= WC()->checkout();
	
	wc_print_notices();
	
	// If checkout registration is disabled and not logged in, the user cannot checkout
	if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
		echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
		return;
	}

	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
?>
<?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>
<!-- summary --------------------------------------- -->
<li id="summary" class="sv_checkout-nav-body-item active">

	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-7">
				<label class="font-weight-bold mb-4"><?php _e('Rechnungsadresse','sv_woocommerce'); ?></label>
				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<p>
							<?php echo get_user_meta(get_current_user_id(), 'billing_company', true); ?><br />
							<?php echo get_user_meta(get_current_user_id(), 'billing_first_name', true); ?> <?php echo get_user_meta(get_current_user_id(), 'billing_last_name', true); ?>
						</p>
						<p>
							<?php echo get_user_meta(get_current_user_id(), 'billing_address_1', true); ?><br />
							<?php echo get_user_meta(get_current_user_id(), 'billing_postcode', true); ?> <?php echo get_user_meta(get_current_user_id(), 'billing_city', true); ?><br />
							<?php
								$countries = new \WC_Countries();
								echo $countries->get_allowed_countries()[get_user_meta(get_current_user_id(), 'billing_country', true)];
							?>
						</p>
						<p>&nbsp;</p>
						<label class="font-weight-bold mb-4">Persönliche Informationen</label>
						<p>
							<?php echo get_user_meta(get_current_user_id(), 'billing_phone', true); ?><br />
							<?php echo get_user_meta(get_current_user_id(), 'billing_email', true); ?>
						</p>
						<p>&nbsp;</p>
						<label class="font-weight-bold mb-4">Zusätzliche Informationen</label>
						<?php
							if($checkout->get_checkout_fields()){
								do_action( 'woocommerce_checkout_before_customer_details' );
								do_action( 'woocommerce_checkout_billing' );
								do_action( 'woocommerce_checkout_shipping' );
								do_action( 'woocommerce_checkout_after_customer_details' );
							}
							do_action( 'woocommerce_checkout_before_order_review' );
							do_action( 'woocommerce_checkout_after_order_review' );
							wc_get_template('checkout/terms.php');
						?>
					</div>
				</div>
				<p>&nbsp;</p>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-7 position-static gform_no_header">
						<h5>Ihre Vorteile auf einen Blick:</h5>
						<ul class="list-style-check list-style-color-primary mb-5">
							<li>Topaktuelle Seminare zu Themen, die die Welt bewegen</li>
							<li>Hohe Interaktion im Seminar und sehr großer Anteil an
				praktischen Übungen</li>
							<li>Kleine Gruppengrößen bis zu 12 Teilnehmern</li>
							<li>Alle Trainer sind erfahrene Entrepreneure und können
				aus ihrer Erfahrung berichten
				</li>
							<li>Weiterempfehlungsrate von 97%</li>
							<li>Über 500 Seminare mit über 7.500 zufriedenen
				Teilnehmern in 2017</li>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-5 sv_woo_cart_sidebar_content coupon mt-0">
				<?php echo do_shortcode('[sv_woocommerce_custom template="cart"]'); ?>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col-xs-12 col-sm-5 col-md-3 col-lg-2 p-3">
				<a href="<?php echo wc_get_cart_url(); ?>" class="btn bg-black text-white w-100">Zurück</a>
			</div>
			<div class="col-xs-12 col-sm-7 col-md-9 col-lg-10 p-3">
				<?php wp_nonce_field( 'woocommerce-process_checkout' ); ?>
				<?php woocommerce_checkout_payment(); ?>
			</div>
		</div>
	</form>
	<?php
		//add_action( 'woocommerce_after_checkout_form', 'woocommerce_checkout_coupon_form' );
		//do_action( 'woocommerce_after_checkout_form', $checkout );
	?>
</li>