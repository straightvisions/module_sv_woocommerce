<?php
namespace sv100;

/**
 * @version         4.001
 * @author			straightvisions GmbH
 * @package			sv100
 * @copyright		2020 straightvisions GmbH
 * @link			https://straightvisions.com
 * @since			4.000
 * @license			See license.txt or https://straightvisions.com
 */

class product extends sv_woocommerce {
	protected $post_type = '';

	public function init() {
		// this is just a helper module to reduce settings list size in parent
		$this->load_settings();
	}

	protected function load_settings(): sv_woocommerce {
		$name = $this->get_module_name();
		// ### Post Listing Settings ###
		$this->get_parent()->get_setting( $name.'_background_color' )
			->set_title( __( 'Background Color', 'sv100' ) )
			->set_default_value( '255,255,255,0' )
			->set_is_responsive(true)
			->load_type( 'color' );

		return $this;
	}

	protected function register_scripts(): sv_woocommerce {
		// Styles - Archive
		/*$this->get_script( 'archive_common' )
			->set_path( 'lib/frontend/css/archive/common.css' )
			->set_inline( true );*/

		return $this;
	}
}