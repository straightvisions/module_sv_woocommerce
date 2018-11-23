<div class="woocommerce-cart container bg-white p-0" data-count="<?php echo WC()->cart->get_cart_contents_count(); ?>">
	<ul class="woocommerce-cart-item-list p-0">
		<?php
		foreach(WC()->cart->get_cart() as $cart_item_key => $cart_item){
			include('cart_item.php');
		}
		?>
	</ul>
	<?php include('cart_totals.php'); ?>
</div>
