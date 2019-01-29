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
	class sv_woocommerce extends init{
		static $scripts_loaded						= false;

		public function __construct($path,$url){
			$this->set_section_title('WooCommerce');
			$this->set_section_desc('WooCommerce Settings');
			$this->set_section_type('settings');

			$this->path								= $path;
			$this->url								= $url;
			$this->name								= get_class($this);
			
			add_action( 'wp_enqueue_scripts', array($this, 'remove_woocommerce_styles_scripts'), 99 );
			add_filter('woocommerce_email_headers', array($this, 'woocommerce_completed_order_email_bcc_copy'), 10, 2);
			
			add_action('admin_init', array($this, 'admin_init'));

			if(!is_admin()){
				$this->load_settings();
			}
		}
		public function admin_init(){
			$this->get_root()->add_section($this);
			$this->load_settings();
		}
		public function load_settings() {
			$this->s['completed_order_email_bcc'] = static::$settings->create( $this )
			                                                         ->set_ID( 'completed_order_email_bcc' )
			                                                         ->set_title( 'Completed Order Email - Additional BCC Recipient' )
			                                                         ->set_description( __( 'Set an additional BCC Recipient for completed order email here', $this->get_module_name() ) )
			                                                         ->load_type( 'email' );

			$this->s['checkout_info_title'] =
				static::$settings->create( $this )
				                 ->set_ID( 'checkout_info_title' )
				                 ->set_title( 'Checkout Info Title' )
				                 ->set_description( __( 'The title of the checkout info box.', $this->get_module_name() ) )
				                 ->load_type( 'text' );

			// List Items
			$this->s['chekout_info_list'] =
				static::$settings->create( $this )
				                 ->set_ID( 'chekout_info_list' )
				                 ->set_title( __( 'Checkout Info List', $this->get_module_name() ) )
				                 ->load_type( 'group' )
				                 ->set_loop( - 1 );

			$this->s['chekout_info_list']->run_type()
			                             ->add_child( $this )
			                             ->set_ID( 'list_item' )
			                             ->set_title( __( 'List Item', $this->get_module_name() ) )
			                             ->set_description( __( 'This list item will be shown in the checkout info box.', $this->get_module_name() ) )
			                             ->load_type( 'text' );
		}
		// add bbc to emails
		public function woocommerce_completed_order_email_bcc_copy( $headers, $email_type ) {
			if ($email_type == 'customer_completed_order') {
				if($this->s['completed_order_email_bcc']->run_type()->get_data()){
					$emails = str_replace(' ','', $this->s['completed_order_email_bcc']->run_type()->get_data());
					$headers .= 'BCC: '.$emails."\r\n";
				}
			}
			// review implement notices here
			return $headers;
		}
		public function remove_woocommerce_styles_scripts() {
			// Dequeue WooCommerce styles
			wp_dequeue_style('woocommerce-layout'); 
			wp_dequeue_style('woocommerce-general'); 
			wp_dequeue_style('woocommerce-smallscreen'); 	
 
			// Dequeue WooCommerce scripts
			wp_dequeue_script('wc-cart-fragments');
			wp_dequeue_script('woocommerce'); 
			wp_dequeue_script('wc-add-to-cart'); 
		}
		public function woocommerce_queued_js($js){
			return '
				<script type="text/javascript" id="'.$this->get_module_name().'">
					window.addEventListener( "load", function() { '.
						preg_replace('#<script(.*?)>(.*?)</script>#is', '$2', $js).'
					}, false );
				</script>
			';
		}

	}
