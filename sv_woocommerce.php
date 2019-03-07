<?php
namespace sv_100;

/**
 * @version         1.00
 * @author			straightvisions GmbH
 * @package			sv_100
 * @copyright		2017 straightvisions GmbH
 * @link			https://straightvisions.com
 * @since			1.0
 * @license			See license.txt or https://straightvisions.com
 */

class sv_woocommerce extends init {
	public function __construct() {

	}

	public function init() {
		// Module Info
		$this->set_module_title( 'SV WooCommerce' );
		$this->set_module_desc( __( 'This module gives the ability to manage WooCommerce templates.', $this->get_module_name() ) );

		// Section Info
		$this->set_section_title( 'WooCommerce' );
		$this->set_section_desc( 'WooCommerce Settings' );
		$this->set_section_type( 'settings' );
		$this->get_root()->add_section( $this );

		// Loads Styles
		static::$scripts->create( $this )
		                ->set_path( $this->get_path( 'lib/css/frontend.css' ) );

		// Loads Settings
		$this->load_settings();

		// Action Hooks
		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'remove_woocommerce_styles_scripts' ), 99 );
		add_filter( 'woocommerce_email_headers', array( $this, 'woocommerce_completed_order_email_bcc_copy' ), 10, 2 );
		add_filter( 'wc_get_template', array( $this, 'wc_get_template' ), 10, 5 );
	}

	public function load_settings() {
		$this->s['completed_order_email_bcc'] = static::$settings->create( $this )
		                                                         ->set_ID( 'completed_order_email_bcc' )
		                                                         ->set_title( __( 'Completed Order Email - Additional BCC Recipient', $this->get_module_name() ) )
		                                                         ->set_description( __( 'Set an additional BCC Recipient for completed order email here', $this->get_module_name() ) )
		                                                         ->load_type( 'email' );
	}

	public function after_setup_theme() {
		add_theme_support( 'woocommerce' );
	}

	// add bbc to emails
	public function woocommerce_completed_order_email_bcc_copy( $headers, $email_type ) {
		if ( $email_type == 'customer_completed_order' ) {
			if ( $this->s['completed_order_email_bcc']->run_type()->get_data() ) {
				$emails = str_replace( ' ', '', $this->s['completed_order_email_bcc']->run_type()->get_data() );
				$headers .= 'BCC: ' . $emails . "\r\n";
			}
		}
		// review implement notices here
		return $headers;
	}

	public function wc_get_template( $located, $template_name, $args, $template_path, $default_path ) {
		//var_dump($template_name);
		if ( file_exists( $this->get_path( 'lib/tpl/woocommerce/' . $template_name ) ) ){
			return $this->get_path( 'lib/tpl/woocommerce/' . $template_name );
		} else {
			return $located;
		}
	}

	public function remove_woocommerce_styles_scripts() {
		// Dequeue WooCommerce styles
		wp_dequeue_style( 'woocommerce-layout' );
		wp_dequeue_style( 'woocommerce-general' );
		wp_dequeue_style( 'woocommerce-smallscreen' );

		// Dequeue WooCommerce scripts
		wp_dequeue_script( 'wc-cart-fragments' );
		wp_dequeue_script( 'woocommerce' );
		wp_dequeue_script( 'wc-add-to-cart' );
	}

	public function woocommerce_queued_js( $js ) {
		return '
			<script type="text/javascript" id="' . $this->get_module_name() . '">
				window.addEventListener( "load", function() { '.
		       preg_replace( '#<script(.*?)>(.*?)</script>#is', '$2', $js ) . '
				}, false );
			</script>
		';
	}

}
