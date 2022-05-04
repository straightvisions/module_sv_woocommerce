<div class="sv_setting_subpage">
    <h2><?php _e( 'General', 'sv100' ); ?></h2>
    <h3 class="divider">
    <h3 class="divider"><?php _e( 'Activate WooCommerce Support', 'sv100' ); ?></h3>
    <div class="sv_setting_flex">
		<?php
		echo $module->get_setting( 'woocommerce_support' )->form();
		?>
    </div>
        <h3 class="divider">
    <h3 class="divider"><?php _e( 'Axcxycxcccxycxycxycxycxyc', 'sv100' ); ?></h3>
    <div class="sv_setting_flex">
		<?php
		echo $module->get_setting( 'margin' )->form();
		echo $module->get_setting( 'padding' )->form();
		?>
    </div>
</div>