<?php
/*
 * scans blog directory for uploaded media
 */
function readBlogMedia(){
   # .jpg, .jpeg, .png, .svg, .bmp
   $media_query = new WP_Query(
      array(
         'post_type' => 'attachment',
         'post_status' => 'inherit',
         'posts_per_page' => -1,
       )
    );
   $list = array();
   foreach ($media_query->posts as $post) {
       $list[] = wp_get_attachment_url($post->ID);
   }
   return parseURL($list);
}
function parseURL($list)
{
   $paths = array();
   foreach ($list as $url) {
      $pathArray = parse_url($url);
      $paths[] = $pathArray['path'];
   }
   return $paths;
}
/**
 *	Returns a media info object with the given properties.
 *	Additionally contains the id if media info is stored in database.
 *
 *	@param path string
 *	@param licenseID int
 * @param author string
 *	@param origin string
 *	@returns object
 */
function getValidMediaInfo($path, $licenseID, $author, $origin)
{
	$mediaInfo = getMediaInfo($path);
	if($mediaInfo === NULL) { // if not saved yet
		$mediaInfo = (object) array(
			'path' => $path,
			'license' => $licenseID,
			'author' => $author,
			'origin' => $origin
		);
	} else {
		$mediaInfo->license = $licenseID;
		$mediaInfo->author = $author;
		$mediaInfo->origin = $origin;
	}
	return $mediaInfo;
}
/**
 *	Saves or insert the media info object to the database if the licenseID is valid.
 *
 *	@param mediaInfo object
 * 	@returns bool
 */
function tryChangeMediaInfo($mediaInfo)
{
	$license = getLicense($mediaInfo->license);

	if($license === NULL) {
		return false;
	} else {
		$rc = saveMediaInfo($mediaInfo);
		return true;
	}
}
?>
