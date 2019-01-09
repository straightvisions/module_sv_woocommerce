<?php
// review this - remove inline line-height fix and add a custom class to bootstrap
if(wc_coupons_enabled()): ?>

    <div id="sv_woo_cart_sidebar_coupon" class="row d-flex m-0 p-3 grid-medium">
        <p class="col-xs-12 col-sm-12 col-md-6 m-0"><input type="text" id="coupon_code_frontend" name="coupon_code_frontend" class="form-control p-0 w-100 text-center" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" value="" /></p>
        <p class="col-xs-12 col-sm-12 col-md-6 m-0" style="line-height:0;"><button type="button" class="btn btn-secondary p-2 w-100" id="apply_coupon" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><strong><?php esc_attr_e('Apply coupon', 'woocommerce'); ?></strong></button></p>
    </div>

<?php endif; ?>