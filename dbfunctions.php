<?php
function genTablePrefix()
{
   global $wpdb;
   $blogPrefix = $wpdb->get_blog_prefix();
   return $blogPrefix .'zawiw_License_';
}

function getMediaInfoUrl($url)
{
   return getMediaInfo(parse_url($url, PHP_URL_PATH));
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
function saveLicense($license)
{
	global $wpdb;
	$prefix = genTablePrefix();
	$tableName = $prefix.'mediaLicense';
	if($license->id){
   	$stmt = $wpdb->prepare(
   		"UPDATE $tableName SET name=%s,link=%s "
   		."WHERE id=%d",
   		$license->name, $license->link, $license->id
   	);
   	$result = $wpdb->query($stmt);
   	return $result;
   }
   return null;
}
function createLicense($name, $link)
{
	global $wpdb;
	$prefix = genTablePrefix();
	$tableName = $prefix.'mediaLicense';
	$stmt = $wpdb->prepare(
		"INSERT INTO $tableName (name, link) VALUES(%s, %s)",
		$name, $link
	);
	$result = $wpdb->query($stmt);
	return $result;
}
function deleteLicense($id)
{
   global $wpdb;
   $prefix = genTablePrefix();
   $tableName = $prefix.'mediaLicense';
   $stmt = $wpdb->prepare(
      "DELETE FROM $tableName WHERE id=%d",
      $id
   );
   $result = $wpdb->query($stmt);
   return $result;
}
?>
