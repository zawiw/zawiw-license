<?php
function importFrontendCSS () {
   wp_enqueue_style('frontendStyle', plugins_url( 'license_styles.css', __FILE__ ));
}
function importFrontendScript() {
   #wp_enqueue_script('frontendScript', plugins_url( 'license_script.js', __FILE__ ));
}
?>
