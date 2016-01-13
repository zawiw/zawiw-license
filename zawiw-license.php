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
add_action('wp_head', 'importFrontendCSS');
add_action('wp_head', 'importFrontendScript');
add_action('admin_head', 'importStylesheets');
add_action('admin_head', 'importScripts');
add_action('admin_menu', 'zawiwLicenseCreateMenu');
add_action('plugins_loaded', 'licenseLoadTextDomain');
add_filter('the_content', 'test');
require_once dirname( __FILE__ ) .'/admin.php';
require_once dirname( __FILE__ ) .'/init.php';
require_once dirname( __FILE__ ) .'/frontend/render.php';
register_activation_hook(dirname( __FILE__ ).'/zawiw-license.php', 'licenseActivation');
register_deactivation_hook(dirname( __FILE__ ).'/zawiw-license.php', 'licenseDeactivation');

function test($content) {
	return preg_replace_callback('/(<a href="[^"]*">\s*)?(<img class="[^"]*" src="([^"]+)")/i', function ($results) {
		$rawUrl = $results[3];
		$mediaInfo = getMediaInfoUrl($rawUrl);
		if($mediaInfo == null) {
			$internalUrl = preg_replace("/(.*)-[0-9]+x[0-9]+(\..*)/", "$1$2", $rawUrl);
			$mediaInfo = getMediaInfoUrl($internalUrl);
		}
		if($mediaInfo == null) {
			return $results[0];
		}
		$licenseId = $mediaInfo->license;
		$license = getLicense($licenseId);
		$name = $license->name;
		$licenseLink = $license->link;
		$author = $mediaInfo->author;
		$optOrigin = '';
		if($mediaInfo->origin != null) {
			$optOrigin .= ', Quelle: '.$mediaInfo->origin;
		}
		return $results[1]."<span class=\"overlaywrapper\" onclick=\"event.preventDefault();window.open('$licenseLink', '_blank');\">$name, Autor: $author$optOrigin</span>".$results[2];
		}, $content). "<script>jQuery(\".overlaywrapper\").parent().map(function (i, p) { p.className += \"parent-overlay\";return p.className })</script>";
}

?>
