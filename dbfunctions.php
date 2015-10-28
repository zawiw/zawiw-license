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
function saveMediaInfo($mediaInfo)
{
	global $wpdb;
	$prefix = genTablePrefix();
	$tableName = $prefix.'blogMedia';
	$wpdb->show_errors();
	$stmt = $wpdb->prepare(
		"INSERT INTO $tableName (license, author, origin, path) VALUES (%d, %s, %s, %s) "
		."ON DUPLICATE KEY UPDATE license=VALUES(license),author=VALUES(author),origin=VALUES(origin)", 
		$mediaInfo->license, $mediaInfo->author, $mediaInfo->origin, $mediaInfo->path
	);
	$info = $wpdb->query($stmt);
	return $info;
}

function getLicenses()
{
   global $wpdb;
   $prefix = genTablePrefix();
   $tableName = $prefix.'mediaLicense';
   $licenses = $wpdb->get_results('SELECT * FROM ' . $tableName . ' ORDER BY id ASC');
   return $licenses;
}
function getLicense($id)
{
	global $wpdb;
	$prefix = genTablePrefix();
	$tableName = $prefix.'mediaLicense';
	$stmt = $wpdb->prepare("SELECT * FROM $tableName WHERE id = %d LIMIT 1", $id);
	$license = $wpdb->get_row($stmt);
	return $license;
}
?>
