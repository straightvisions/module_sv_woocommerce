<?php $order		= $this->order; ?>
<!-- thankyou -------------------------------------- -->
<li id="thankyou" class="sv_checkout-nav-body-item active">
	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<div class="woocommerce-order card p-4 p-sm-5">
				<?php if ( $order ) : ?>

					<?php if ( $order->has_status( 'failed' ) ) : ?>

						<h3 class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed mb-4"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></h3>

						<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
							<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
							<?php if ( is_user_logged_in() ) : ?>
								<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My account', 'woocommerce' ); ?></a>
							<?php endif; ?>
						</p>

					<?php else : ?>

						<h3 class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received mb-4"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); ?></h3>

						<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details mb-5">

							<li class="woocommerce-order-overview__order order">
								<?php _e( 'Order number:', 'woocommerce' ); ?>
								<strong><?php echo $order->get_order_number(); ?></strong>
							</li>

							<li class="woocommerce-order-overview__date date">
								<?php _e( 'Date:', 'woocommerce' ); ?>
								<strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
							</li>

							<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
								<li class="woocommerce-order-overview__email email">
									<?php _e( 'Email:', 'woocommerce' ); ?>
									<strong><?php echo $order->get_billing_email(); ?></strong>
								</li>
							<?php endif; ?>

							<li class="woocommerce-order-overview__total total">
								<?php _e( 'Total:', 'woocommerce' ); ?>
								<strong><?php echo $order->get_formatted_order_total(); ?></strong>
							</li>

							<?php if ( $order->get_payment_method_title() ) : ?>
								<li class="woocommerce-order-overview__payment-method method">
									<?php _e( 'Payment method:', 'woocommerce' ); ?>
									<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
								</li>
							<?php endif; ?>

						</ul>

					<?php endif; ?>
						<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
						<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
				<?php else : ?>

					<h3 class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></h3>

				<?php endif; ?>

			</div>
		</div>
	</div>
</li>