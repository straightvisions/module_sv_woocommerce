<?php
var_dump(is_checkout());
$this->is_checkout = true;
echo do_shortcode('[sv_woocommerce_custom template="checkout_header"]');
echo do_shortcode('[sv_woocommerce_custom template="checkout_footer"]');
?>