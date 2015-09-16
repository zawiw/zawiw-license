<?php
require_once dirname( __FILE__ ) .'/functions.php';
require_once dirname( __FILE__ ) .'/dbfunctions.php';
function zawiwLicenseCreateMenu()
{
   /*
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
   <?php
   if(!isset($_GET['path']))
   {
      viewBlogMedia();
   } elseif (count($_POST) === 0) {
      alterBlogMedia($_GET['path']);
   } else {
      succeedChangeMedia();
   }
   ?></div><?php
}
function viewBlogMedia()
{
   ?>
      <li>
   <?php
   $blogMedia = readBlogMedia();
   foreach ($blogMedia as $path) {
      preg_match('/.*\.(\w*)$/', $path, $matches);
      switch ($matches[1]) {
         case 'png':
         case 'jpg':
         ?>
         <ul><a href="?page=zawiwLicense&amp;path=<?=$path ?>"><img src="<?=$path ?>" alt="someText" height="150" width="150"/></a></ul>
         <?php
            break;

         default:
         ?>
            <ul><div><?=$matches[1] ?></div></ul>
         <?php
            break;
      }
   }
   ?>
   </li>
   <?php
}
function alterBlogMedia($path)
{
   $info = getMediaInfo($path);
   ?>
   <div class="alterMediaContainer">
      <img src="<?=$path ?>" alt="" class="" />
      <form class="alterMediaForm" method="post" action="" >
         <div><label for="chooseLicense">Lizenz:</label>
            <select  name="chooseLicense" id="chooseLicense">
               <?php  $licenses = getLicenses();
               foreach($licenses as $license) {
                  $selected = $info != null && $info->license === $license->id ? "selected=\"selected\"" : "";
                  echo "<option ". $selected ." value=\"". $license->id ."\">". $license->name ."</option>";
               }
               ?>
            </select>
         </div>
         <div><label for="author">Urheber:</label>
            <input type="text" name="author" id="author" value="<?= $info == null ? "" : $info->author ?>" />
         </div>
         <div><label for="origin">Quelle:</label>
            <input type="text" name="origin" id="origin" value="<?= $info == null ? "" : $info->origin ?>" />
         </div>
         <a class="button" id="cancel" href="?page=zawiwLicense">Abbrechen</a>
         <input type="submit" name="save" id="save" value="Speichern" />
      </form>
   </div>
<?php
}
function succeedChangeMedia()
{
   echo "succed method";
   viewBlogMedia();
}
function importStylesheets()
{

}
function importScripts()
{

}
?>
