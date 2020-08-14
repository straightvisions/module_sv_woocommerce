<div class="sv_setting_subpage">
    <h2><?php _e( 'Product', 'sv100' ); ?></h2>
    <h3 class="divider"><?php _e( 'Background Color', 'sv100' ); ?></h3>
    <div class="sv_setting_flex">
		<?php
		echo $module->get_setting( 'background_color' )->form();
		?>
    </div>
</div>