<?php

if(wc_coupons_enabled()): ?>

    <div id="sv_woo_cart_sidebar_coupon" class="row d-flex m-0 p-0 pt-3 pr-3 pl-3 grid-medium">
        <p class="col-xs-12 col-sm-12 col-md-6 m-0"><input type="text" id="coupon_code_frontend" name="coupon_code_frontend" class="form-control p-3 w-100 text-center text-uppercase" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" value="" /></p>
        <p class="col-xs-12 col-sm-12 col-md-6 m-0"><button type="button" class="btn btn-primary p-4 w-100" id="apply_coupon" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><strong><?php esc_attr_e('Apply coupon', 'woocommerce'); ?></strong></button></p>
    </div>

<?php endif; ?>