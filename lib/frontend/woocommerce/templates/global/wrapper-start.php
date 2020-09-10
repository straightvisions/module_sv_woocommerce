<?php

$module = $GLOBALS['sv100']->get_module('sv_woocommerce');

/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$template = wc_get_theme_slug_for_templates();

switch ( $template ) {
	default:
		echo '<div id="primary" class="content-area sv100_sv_content sv100_sv_wocommerce sv100_sv_woocommerce_wrapper"><main id="main" class="site-main sv100_sv_woocommerce_wrapper_inner" role="main">';
		break;
}
?>
<div>
	<?php include('sidebar_top.php'); ?>
</div>
<div>
	<?php include('sidebar_left.php'); ?>
</div>

