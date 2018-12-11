<?php
	namespace sv_100;
	
	/**
	 * @author			Matthias Reuter
	 * @package			sv_100
	 * @copyright		2017 Matthias Reuter
	 * @link			https://straightvisions.com
	 * @since			1.0
	 * @license			See license.txt or https://straightvisions.com
	 */
	class sv_woocommerce_custom extends sv_woocommerce{
		public $order								= false;
		public $is_checkout							= false;

		public function custom(){
			add_action('wp', array($this, 'wp'));
			// gravity forms specific
			add_filter('gform_countries', array($this, 'gform_countries'));
			add_action('gform_user_updated', array($this, 'gform_user_updated'), 10, 4);
			// as gravity forms takes care for billing fields, hide them on checkout
			add_filter('woocommerce_checkout_fields', array($this, 'woocommerce_checkout_fields'));
			add_action('woocommerce_checkout_order_processed', array($this, 'woocommerce_checkout_order_processed'), 10, 3); // hook into order once it's into database, but before it's further processed
			add_filter('sv_gravity_forms_qualified_vat_check_base_country', function($base_country){ return WC()->countries->get_base_country(); });
			add_filter('sv_woo_cart_sidebar', array($this, 'sv_woo_cart_sidebar'));
			add_filter('sv_woo_cart_sidebar_cart_item', array($this, 'sv_woo_cart_sidebar_cart_item'), 10, 3);
			add_shortcode($this->get_module_name(), array($this, 'shortcode'));
			add_action('wp_loaded', array($this, 'set_vat_exempt'));
			add_action('init', array($this, 'exclude_from_search'));
		}
		public function exclude_from_search(){
			// exclude from search results
			if(post_type_exists('product')){
				global $wp_post_types;
				$wp_post_types['product']->exclude_from_search		= true;
			}
		}
		public function set_vat_exempt(){
			if(!is_admin() && function_exists('WC') &&  isset(WC()->cart) && WC()->cart->get_customer()){
				if(
					$this->get_vat_sanitized() && // vat number exists? we assume it's validated upon save
					$this->get_vat_country_code() != WC()->countries->get_base_country() && // vat number is not base country of store?
					$this->get_vat_country_code() == WC()->customer->get_billing_country() // vat number country is same as billing country?
				){
					WC()->customer->set_is_vat_exempt(true);
				}else{
					WC()->customer->set_is_vat_exempt(false);
				}
			}
		}
		public function sv_woo_cart_sidebar($cart){
			ob_start();
			include($this->get_path('lib/tpl/cart.php'));
			return ob_get_clean();
		}
		public function sv_woo_cart_sidebar_cart_item($html, $cart_item, $_product, $cart_item_key){
			ob_start();
			include($this->get_path('lib/tpl/cart_item.php'));
			return ob_get_clean();
		}
		public function shortcode($settings):string{
			$this->module_enqueue_scripts(true);
			$settings									= shortcode_atts(
				array(
					'template'							=> false,
					'checkout'                          => false
				),
				$settings,
				$this->get_module_name()
			);
			if(isset($settings['template']) && file_exists($this->get_path('lib/tpl/'.$settings['template'].'.php'))){
				ob_start();
				include($this->get_file_path('lib/tpl/'.$settings['template'].'.php'));
				return ob_get_clean();
			}
			return '';
		}
		public function wp(){
			// custom wc styles
			if(function_exists('is_checkout') && is_checkout()){
				$this->module_enqueue_scripts(true);
			}
		}
		// only allow those countries in gravity forms that are allowed in WC, too
		public function gform_countries($countries){
			$new_countries							= array();
			$wc_countries							= new \WC_Countries();
			$allowed_countries						= $wc_countries->get_allowed_countries();

			foreach($countries as $country){
				$code								= \GF_Fields::get('address')->get_country_code($country);
				if(isset($allowed_countries[$code])){
					$new_countries[$code]			= $country;
				}
			}

			return $new_countries;
		}
		// update session after address change
		public function gform_user_updated($user_id, $feed, $entry, $user_pass){
			if(function_exists('WC') && WC()->cart){ // is_vat_exempt is not stored persistently, so we update cart user session
				$cart									= WC()->cart;
				$user									= $cart->get_customer();

				$user->set_props( array(
					'billing_country'					=> $user->get_billing_country(),
					'billing_state'						=> $user->get_billing_state(),
					'billing_postcode'					=> $user->get_billing_postcode(),
					'billing_city'						=> $user->get_billing_city(),
					'billing_address_1'					=> $user->get_billing_address_1(),
					'billing_address_2'					=> $user->get_billing_address_2(),
					'billing_company'					=> $user->get_billing_company(),
				));
			}
		}
		private function get_vat_sanitized($vat = false){
			if(!$vat){
				$vat									= get_user_meta(get_current_user_id(), 'vat_number', true);
			}
			if($vat){
				return strtoupper(preg_replace("/[^A-Za-z0-9]/", '', $vat));
			}else{
				return false;
			}
		}
		private function get_vat_country_code($vat = false){
			if($this->get_vat_sanitized($vat)){
				return substr($this->get_vat_sanitized($vat), 0, 2);
			}else{
				return false;
			}
		}
		// Our hooked in function - $fields is passed via the filter!
		public function woocommerce_checkout_fields($fields){
			foreach($fields['billing'] as $key => $val){
				unset($fields['billing'][$key]);
				//$fields['billing'][$key]['type']				= 'hidden';
			}

			return $fields;
		}
		public function woocommerce_checkout_order_processed($order_id, $posted_data, $order){
			$user_id								= $order->get_customer_id(); // don't use get_current_user_id here, as other users may visit this page if they know the url
			$customer								= new \WC_Customer($user_id);

			if(
				$this->get_vat_sanitized() && // vat number exists? we assume it's validated upon save
				$this->get_vat_country_code() != WC()->countries->get_base_country() && // vat number is not base country of store?
				$this->get_vat_country_code() == $customer->get_billing_country() // vat number country is same as billing country?
			){
				add_filter('woocommerce_order_is_vat_exempt', '__return_true');
				$order->update_meta_data('_sv_bb_vat_number', $this->get_vat_sanitized());
				$order->update_meta_data('is_vat_exempt', 'yes');
			}else{
				add_filter('woocommerce_order_is_vat_exempt', '__return_false');
			}

			// update billing fields
			$order->set_billing_country($customer->get_billing_country());
			$order->set_billing_state($customer->get_billing_state());
			$order->set_billing_postcode($customer->get_billing_postcode());
			$order->set_billing_city($customer->get_billing_city());
			$order->set_billing_address_1($customer->get_billing_address_1());
			$order->set_billing_address_2($customer->get_billing_address_2());
			$order->set_billing_company($customer->get_billing_company());
			$order->set_billing_first_name($customer->get_billing_first_name());
			$order->set_billing_last_name($customer->get_billing_last_name());

			$order->save();
			$order->calculate_totals(true);

			return $order_id;
		}
	}
