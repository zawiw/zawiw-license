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

?>
