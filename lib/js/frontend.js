jQuery(document).ready(function(){
	jQuery(document.body).on('checkout_error', function(){
		jQuery('html, body').stop();
		jQuery('html, body').animate({
			scrollTop: (jQuery('form.checkout').offset().top - 200)
		}, 500);
	});
	jQuery('#sv_checkout_step_review, #sv_forward_to_checkout').on('click', function(){
		jQuery('#sv_checkout_step_review').addClass('btn-primary').removeClass('btn-secondary');
		jQuery('#sv_checkout_step_account').addClass('btn-success text-black').removeClass('btn-primary text-white');
	});
	jQuery('#sv_checkout_step_account').on('click', function(){
		jQuery('#sv_checkout_step_review').removeClass('btn-primary').addClass('btn-secondary');
		jQuery('#sv_checkout_step_account').removeClass('btn-success text-black').addClass('btn-primary text-white');
	});
	
	jQuery('#woocommerce_error').modal('show');
	jQuery('#woocommerce_info').modal('show');
	jQuery('#woocommerce_message').modal('show');

	// GA cart item remove
	jQuery('body').on('click', '.cart-action-remove', function(){
		// run GA event
		ga("ec:addProduct", {
			"id": jQuery(this).data('id'),
			"name": jQuery(this).data('title'),
			"category": jQuery(this).data('product'),
			"brand": 'seminars',
			"variant": jQuery(this).data('variant'),
			"price": jQuery(this).data('price'),
			"quantity": jQuery(this).data('quantity')
		});
		ga("ec:setAction", "remove");
		ga("send", "event", "Checkout", "Remove from Cart", jQuery(this).data('product'), jQuery(this).data('price'));     // Send data using an event.
	});
	// GA cart quantity
	jQuery('body').on('change', '.woocommerce-qty-select', function(){
		var difference		= (
			(jQuery(this).data('prev_val') > jQuery(this).val())
			? jQuery(this).data('prev_val')-jQuery(this).val()
			: jQuery(this).val()-jQuery(this).data('prev_val')
		);
		var i				= 0;
		console.log('difference: '+difference);

		// run GA event
		ga("ec:addProduct", {
			"id": jQuery(this).data('id'),
			"name": jQuery(this).data('title'),
			"category": jQuery(this).data('product'),
			"brand": 'seminars',
			"variant": jQuery(this).data('variant'),
			"price": jQuery(this).data('price'),
			"quantity": difference,
		});

		if(jQuery(this).val() > jQuery(this).data('prev_val')){
			// quantity increased
			ga("ec:setAction", "add");
			//while(i < difference) {
				ga("send", "event", "Checkout", "Add to Cart", jQuery(this).data('product'), jQuery(this).data('price'));     // Send data using an event.
				ga("send", "event", "Checkout", "Cart Item Quantity Increased", jQuery(this).data('product'), jQuery(this).data('price')*difference);     // Send data using an event.
				//i++;
			//}
			//console.log(i+' items added');
		}else{
			// quantity decreased
			ga("ec:setAction", "remove");
			//while(i < difference) {
				ga("send", "event", "Checkout", "Remove from Cart", jQuery(this).data('product'), jQuery(this).data('price'));     // Send data using an event.
				ga("send", "event", "Checkout", "Cart Item Quantity Decreased", jQuery(this).data('product'), jQuery(this).data('price')*difference);     // Send data using an event.
				//i++;
			//}
			//console.log(i+' items removed');
		}
	});
	// GA cart model
	jQuery('body').on('shown.bs.modal', '#wc_modal_cart', function (e) {
		// modal cart made visible
		ga("send", "event", "Checkout", "Cart Modal opened");     // Send data using an event.
	})
	jQuery('body').on('hidden.bs.modal', '#wc_modal_cart', function (e) {
		// modal cart made invisible
		ga("send", "event", "Checkout", "Cart Modal closed");     // Send data using an event.
	})
});
	