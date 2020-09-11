<?php
	namespace sv100;

	/**
	 * @version         4.001
	 * @author			straightvisions GmbH
	 * @package			sv_100
	 * @copyright		2020 straightvisions GmbH
	 * @link			https://straightvisions.com
	 * @since			1.0
	 * @license			See license.txt or https://straightvisions.com
	 */

	class sv_woocommerce extends init {

		public function init() {
			$this->set_module_title( __( 'SV WooCommerce', 'sv100' ) )
				->set_module_desc( __( 'This module gives the ability to manage WooCommerce templates.', 'sv100' ) )
				->load_settings()
				->register_sidebars()
				->register_scripts()
				->load_child_modules()
				->set_section_title( __( 'WooCommerce', 'sv100' ) )
				->set_section_desc( $this->get_module_desc() )
				->set_section_type( 'settings' )
				->set_section_template_path( $this->get_path( 'lib/backend/tpl/settings.php' ) )
				->get_root()
				->add_section( $this );

			// Action Hooks
			add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );

			//Redirect template @todo only redirect when module is activated


			// opt-in
			if( (bool) $this->get_setting('woocommerce_support')->get_data() === true ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'remove_woocommerce_styles_scripts' ), 99 );
				add_filter('wc_get_template', array($this, 'wc_get_template'), 10, 5);
				add_filter( 'woocommerce_template_path', array($this, 'get_template_path'), 10, 5);

				add_action('wp', function(){
					$this->get_module('sv_content')->get_script( 'content_common' )->set_is_enqueued();
					$this->get_module('sv_content')->get_script( 'content_single' )->set_is_enqueued();
					$this->get_module('sv_content')->get_script( 'config' )->set_is_enqueued();
				});


			}


		}

		public function get_template_path($path){
			//@todo test child theme overwrite
			$template_path = $this->get_path('lib/frontend/woocommerce/');

			return file_exists( $template_path ) ? $template_path : $path;
		}

		public function after_setup_theme() {
			add_theme_support( 'woocommerce' );
		}

		public function remove_woocommerce_styles_scripts() {
			$woocommerce_support = $this->get_setting('woocommerce_support');

			if( (bool)$woocommerce_support->get_data() === true && 1==2 ){
				// Dequeue WooCommerce styles
				wp_dequeue_style( 'woocommerce-layout' );
				wp_dequeue_style( 'woocommerce-general' );
				wp_dequeue_style( 'woocommerce-smallscreen' );

				// Dequeue WooCommerce scripts
				wp_dequeue_script( 'wc-cart-fragments' );
				wp_dequeue_script( 'woocommerce' );
				wp_dequeue_script( 'wc-add-to-cart' );
			}

		}

		public function wc_get_template( $located, $template_name, $args, $template_path, $default_path ) {
			if ( file_exists( $this->get_path( 'lib/frontend/woocommerce/templates/' . $template_name ) ) ){
				return $this->get_path( 'lib/frontend/woocommerce/templates/' . $template_name );
			} else {
				return $located;
			}
		}

		protected function load_settings(): sv_woocommerce{
			$sv_content = $this->get_module('sv_content');

			// prime
			$this->get_setting('woocommerce_support')
				->set_title(__('Activate ', 'sv100'))
				->load_type('checkbox');

			$this->get_setting( 'margin' )
				->set_title( __( 'Margin', 'sv100' ) )
				->set_is_responsive(true)
				->load_type( 'margin' );

			$this->get_setting( 'padding' )
				->set_title( __( 'Padding', 'sv100' ) )
				->set_is_responsive(true)
				->set_default_value(
					$sv_content->get_setting('padding')->get_data()
				)
				->load_type( 'margin' );

			return $this;
		}

		protected function register_sidebars(): sv_woocommerce{
			if ( $this->get_module( 'sv_sidebar' ) ) {
				$this->get_module( 'sv_sidebar' )
					->create( $this )
					->set_ID( 'sidebar_top' )
					->set_title( __( 'WooCommerce Top', 'sv100' ) )
					->set_desc( __( 'Widgets in this sidebar will be shown.', 'sv100' ) )
					->load_sidebar()

					->create( $this )
					->set_ID( 'sidebar_bottom' )
					->set_title( __( 'WooCommerce Bottom', 'sv100' ) )
					->set_desc( __( 'Widgets in this sidebar will be shown.', 'sv100' ) )
					->load_sidebar()

					->create( $this )
					->set_ID( 'sidebar_left' )
					->set_title( __( 'WooCommerce Left', 'sv100' ) )
					->set_desc( __( 'Widgets in this sidebar will be shown.', 'sv100' ) )
					->load_sidebar()

					->create( $this )
					->set_ID( 'sidebar_right' )
					->set_title( __( 'WooCommerce Right', 'sv100' ) )
					->set_desc( __( 'Widgets in this sidebar will be shown.', 'sv100' ) )
					->load_sidebar();
			}

			return $this;
		}

		private function register_scripts(): sv_woocommerce{
			//@todo move set_is_enqueued to extra function with test for page type
			$this->get_script( 'grid' )
				->set_path( 'lib/frontend/css/grid.css' )
				->set_inline( true )
				->set_is_enqueued();

			$this->get_script( 'common' )
				->set_path( 'lib/frontend/css/common.css' )
				->set_inline( true )
				->set_is_enqueued();

			$this->get_script( 'navigation_categories' )
				->set_path( 'lib/frontend/css/navigation_categories.css' )
				->set_inline( true )
				->set_is_enqueued();

			$this->get_script( 'sidebars' )
				->set_path( 'lib/frontend/css/sidebars.css' )
				->set_inline( true )
				->set_is_enqueued();

			$this->get_script( 'config' )
				->set_path( 'lib/frontend/css/config.php' )
				->set_inline( true )
				->set_is_enqueued();

			return $this;
		}

		// Loads required child modules
		protected function load_child_modules(): sv_woocommerce {
			// might be obsolete
			$list = array(
				'product',
			// etc.
			);

			foreach($list as $name){
				require_once( $this->get_path('lib/modules/'.$name.'.php') );
				$class = 'sv100\\'.$name;
				$module = new $class();
				$module
					->set_root( $this->get_root() )
					->set_parent( $this )
					->init();

				$this->{'woocommerce_'.$name} = $module;
			}

			return $this;
		}

	}