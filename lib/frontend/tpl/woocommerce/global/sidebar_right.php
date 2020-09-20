<?php
$module = $GLOBALS['sv100']->get_module('sv_woocommerce');
echo $module->get_module('sv_sidebar')->load(array('id' => $module->get_module_name().'_sidebar_right'));