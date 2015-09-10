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

add_action('admin_menu', 'zawiwLicenceCreateMenu');
require_once dirname( __FILE__ ) .'/admin.php';
require_once dirname( __FILE__ ) .'/init.php';
?>
