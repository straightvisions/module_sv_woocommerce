<?php
	namespace sv100;

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
		public function init() {
			$this->set_module_title( __( 'SV WooCommerce', 'sv100' ) )
				->set_module_desc( __( 'This module gives the ability to manage WooCommerce templates.', 'sv100' ) )
				->set_section_title( __( 'WooCommerce', 'sv100' ) )
				->set_section_desc( $this->get_module_desc() )
				->set_section_type( 'settings' )
				->get_root()
				->add_section( $this );

			// Action Hooks
			add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'remove_woocommerce_styles_scripts' ), 99 );
			add_filter( 'wc_get_template', array( $this, 'wc_get_template' ), 10, 5 );

			add_action('wp', function(){
				$this->get_module('sv_content')->get_script( 'content_common' )->set_is_enqueued();
				$this->get_module('sv_content')->get_script( 'content_single' )->set_is_enqueued();
			});
		}
		public function after_setup_theme() {
			add_theme_support( 'woocommerce' );
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
		public function wc_get_template( $located, $template_name, $args, $template_path, $default_path ) {
			if ( file_exists( $this->get_path( 'lib/frontend/tpl/' . $template_name ) ) ){
				return $this->get_path( 'lib/frontend/tpl/' . $template_name );
			} else {
				return $located;
			}
		}
	}