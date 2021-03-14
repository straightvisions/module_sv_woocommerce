<?php
	namespace sv100;

	class sv_woocommerce extends init {
		public function init() {
			$this->set_module_title( __( 'SV WooCommerce', 'sv100' ) )
				->set_module_desc( __( 'This module gives the ability to manage WooCommerce templates.', 'sv100' ) )
				->set_css_cache_active()
				->set_section_title( $this->get_module_title() )
				->set_section_desc( $this->get_module_desc() )
				->set_section_type( 'settings' );

			// Action Hooks
			add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
			//add_action( 'wp_enqueue_scripts', array( $this, 'remove_woocommerce_styles_scripts' ), 99 );
			add_filter( 'wc_get_template', array( $this, 'wc_get_template' ), 10, 5 );

			add_action('wp', function(){
				$this->get_module('sv_content')->get_script( 'content_common' )->set_is_enqueued();
				$this->get_module('sv_content')->get_script( 'content_single' )->set_is_enqueued();
				$this->get_module('sv_content')->get_script( 'config' )->set_is_enqueued();
			});
		}
		public function after_setup_theme() {
			//add_theme_support( 'woocommerce' );
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
			$this->register_scripts();

			if ( is_file( $this->get_path( 'lib/frontend/tpl/' . $template_name ) ) ){
				return $this->get_path( 'lib/frontend/tpl/' . $template_name );
			} else {
				return $located;
			}
		}
	}