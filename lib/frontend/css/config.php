<?php
/* css namespace */
$namespace = 'sv100_sv_content';

echo $_s->build_css(
	is_admin() ? '' : '.sv100_sv_woocommerce_wrapper > .sv100_sv_woocommerce_wrapper_inner',
	array_merge(
		$script->get_parent()->get_setting('padding')->get_css_data('padding'),
		$script->get_parent()->get_setting('margin')->get_css_data()
	)
);