<?php
$module = $GLOBALS['sv100']->get_module('sv_woocommerce');
echo $module->get_module('sv_sidebar')->load($module->get_prefix().'_sidebar_bottom');