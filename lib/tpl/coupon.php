<?php
if(!wc_coupons_enabled()){
	return;
}
?>
<div class="row d-flex m-0 p-0 mt-4 sv_checkout_coupon">
	<div class="col-12 col-sm-6 pr-sm-3 mb-3 mb-sm-0"><input type="text" form="sv_checkout_coupon" name="coupon_code_frontend" class="form-control w-100 h-100 text-center" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code_frontend" value="" /></div>
	<div class="col-12 col-sm-6 pl-sm-3"><button type="submit" form="sv_checkout_coupon" class="btn btn-primary w-100" id="apply_coupon" name="apply_coupon" value="<?php _e( 'Apply coupon', 'woocommerce' ); ?>"><?php _e( 'Apply coupon', 'woocommerce' ); ?></button></div>
</div>