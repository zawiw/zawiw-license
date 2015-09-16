<?php
function genTablePrefix()
{
   global $wpdb;
   $blogPrefix = $wpdb->get_blog_prefix();
   return $blogPrefix .'zawiw_License_';
}
function getMediaInfo($path)
{
   global $wpdb;
   $prefix = genTablePrefix();
   $tableName = $prefix.'blogMedia';
   $info = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $tableName . ' WHERE path=%s LIMIT 1', $path));
   if(count($info) > 0) {
      return $info[0];
   }
   return null;
}
function getLicenses()
{
   global $wpdb;
   $prefix = genTablePrefix();
   $tableName = $prefix.'mediaLicense';
   $licenses = $wpdb->get_results('SELECT * FROM ' . $tableName . ' ORDER BY id ASC');
   return $licenses;
}
?>
