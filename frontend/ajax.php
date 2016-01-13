<?php
#go to html/wp-load.php of documentRoot
require_once('../../../../wp-load.php');

/*
function ()
{
	$mediaPath = $_GET['license_mediaPath'];
	$mediaInfo = getMediaInfo($mediaPath);
	
	$response = array();
	if ($mediaInfo != null) {
		$licenseId = $mediaInfo->license;
		$response = (array)getLicense($licenseId);
		$response['code'] = 200;
	} else {
		$response['code'] = 404;
	}
	print json_encode($response);
}*/

?>
