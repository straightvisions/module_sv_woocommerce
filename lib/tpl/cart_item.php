<?php
$_product   						= apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
if($_product && is_object($_product) && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)){
    if(isset($cart_item['_sv_bb_dashboard_roombooking'])){
		include('cart_item_roombooking.php');
    }else{
        include('cart_item_seminar.php');
    }
}
?>