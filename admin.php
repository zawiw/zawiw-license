<?php
require_once dirname( __FILE__ ) .'/functions.php';
function zawiwLicenseCreateMenu()
{
   /*
   upload.php slug for media
   check capability
   add_media_page( $page_title, $menu_title, $capability, $menu_slug, $function);
   */
   add_media_page('zawiwLicense', 'License', 'upload_files', 'zawiwLicense', 'zawiwLicenseBackend');
}
function zawiwLicenseBackend()
{
?>
   <div id="zawiwLicenseAdminArea">
      <h1>hallo valentin</h1>
   </div>
   <li>
<?php
$blogMedia = readBlogMedia();
foreach ($blogMedia as $path) {
   preg_match('/.*\.(\w*)$/', $path, $matches);
   switch ($matches[1]) {
      case 'png':
      case 'jpg':
      ?>
      <ul><img src="<?=$path ?>" alt="someText" height="150" width="150"/></ul>
      <?php
         break;

      default:
      ?>
         <ul><div><?=$matches[1] ?></div></ul>
      <?php
         break;
   }
      #placeholder thumbnail

}
?>
</li>
<?php
}
?>
