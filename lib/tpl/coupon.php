<?php
if(!wc_coupons_enabled()){
	return;
}
?>
<form method="post" class="card-deck sv_checkout_coupon">
	<div class="card my-0 <?php if(is_checkout()) { echo 'coupon_card_checkout'; } ?>">
		<div class="row d-flex">
			<h5 class="col-xs-12 col-sm-12"><?php echo __('Have a coupon?', 'woocommerce'); ?></h5>
			<p class="col-xs-12 col-sm-12 col-md-7"><input type="text" name="coupon_code" class="form-control shadow-1 p-3 w-100" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" id="coupon_code" value="" /></p>
			<p class="col-xs-12 col-sm-12 col-md-5"><button type="submit" class="btn btn-success p-4 w-100" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><strong><?php esc_attr_e('Apply coupon', 'woocommerce'); ?></strong></button></p>
		</div>
	</div>
</form>