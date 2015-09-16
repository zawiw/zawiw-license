<?php
/*
Plugin Name: Zawiw License
Plgin URI:
Description: Wordpress Plugin for media licenses
Version: 0.1
Author: Georg Eisenhart, Valentin Knabel
Author URI:
License: MIT
*/

add_action('admin_head', 'importStylesheets');
add_action('admin_head', 'importScripts');
add_action('admin_menu', 'zawiwLicenseCreateMenu');
require_once dirname( __FILE__ ) .'/admin.php';
require_once dirname( __FILE__ ) .'/init.php';
register_activation_hook(dirname( __FILE__ ).'/zawiw-license.php', 'licenseActivation');
register_deactivation_hook(dirname( __FILE__ ).'/zawiw-license.php', 'licenseDeactivation');
?>
