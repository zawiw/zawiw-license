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
      <h1><?= __('ZAWiW License', 'zawiw-license') ?></h1>
   <?php
   if(!isset($_GET['path']))
   {
      viewBlogMedia();
   } elseif (count($_POST) === 0) {
      alterBlogMedia($_GET['path']);
   } else {
      succeedChangeMedia($_POST['path'], $_POST['chooseLicense'], $_POST['author'], $_POST['origin']);
   }
   ?></div><?php
}
function viewBlogMedia()
{
   ?>
      <ul>
   <?php
   $blogMedia = readBlogMedia();
   foreach ($blogMedia as $path) {
      preg_match('/.*\.(\w*)$/', $path, $matches);
      switch ($matches[1]) {
         case 'png':
         case 'jpg':
         case 'jpeg':
         case 'gif':
         case 'svg':
         ?>
         <li>
	         <a href="?page=zawiwLicense&amp;path=<?=$path ?>"><img src="<?=$path ?>" alt="<?= basename($path) ?>" height="150" width="150"/></a>
	     </li>
         <?php
            break;

         default:
         ?>
            <li>
            	<a href="?page=zawiwLicense&amp;path=<?=$path ?>">
	            	<img src="http://mirror.forschendes-lernen.de/wp-includes/images/media/document.png" alt="<?= basename($path) ?>" />
					<br/>
					<?=$matches[1] ?>
				</a>
	        </li>
         <?php
            break;
      }
   }
   ?>
   </ul>
   <?php
}
function alterBlogMedia($path)
{
   $info = getMediaInfo($path);
   ?>
   <div class="alterMediaContainer">
      <img src="<?=$path ?>" alt="" class="" />
      <form class="alterMediaForm" method="post" action="" >
         <div>
	        <input type="hidden" name="path" value="<?= $path ?>" />
	        <label for="chooseLicense"><?= __('License:', 'zawiw-license') ?></label>
			<select  name="chooseLicense" id="chooseLicense">
               <?php  $licenses = getLicenses();
               foreach($licenses as $license) {
                  $selected = $info != null && $info->license === $license->id ? "selected=\"selected\"" : "";
                  echo "<option ". $selected ." value=\"". $license->id ."\">". $license->name ."</option>";
               }
               ?>
            </select>
         </div>
         <div><label for="author"><?= __('Author:', 'zawiw-license') ?></label>
            <input type="text" name="author" id="author" value="<?= $info == null ? "" : $info->author ?>" />
         </div>
         <div><label for="origin"><?= __('Source:', 'zawiw-license') ?></label>
            <input type="text" name="origin" id="origin" value="<?= $info == null ? "" : $info->origin ?>" />
         </div>
         <a class="button" id="cancel" href="?page=zawiwLicense"><?= __('Abort', 'zawiw-license') ?></a>
         <input class="button" type="submit" name="save" id="save" value="<?= __('Save', 'zawiw-license') ?>" />
      </form>
   </div>
<?php
}

function succeedChangeMedia($path, $licenseID, $author, $origin)
{
	$mediaInfo = getMediaInfo($path);
	if($mediaInfo === NULL) { // if not saved yet
		$mediaInfo = (object) array(
			'path' => $path,
			'license' => $licenseID,
			'author' => $author,
			'origin' => $origin
		);
	}
	$fileName = basename($mediaInfo->path);
	$license = getLicense($licenseID);
	if($license === NULL) {
		displayError(sprintf(__("The provided license for %s is invalid.", 'zawiw-license'), $fileName));
	} else {
		$mediaInfo->license = $licenseID;
		$mediaInfo->author = $author;
		$mediaInfo->origin = $origin;
		$rc = saveMediaInfo($mediaInfo);

		if($rc > 0)
			displayUpdated(sprintf(__("Updated license of %s to %s."), $fileName, "<a target=\"_blank\" href=\"$license->link\">$license->name</a>."));
		else 
			displayError(sprintf(__("Nothing to save for %s."), $fileName));
	}
	
   viewBlogMedia();
}
function importStylesheets()
{

}
function importScripts()
{

}

function displayUpdated($msg) 
{
	?>
	<div class="updated">
		<p>
			<?= $msg ?>
		</p>
	</div>
	<?php
}
function displayError($msg) 
{
	?>
	<div class="error">
		<p>
			<?= $msg ?>
		</p>
	</div>
	<?php
}

?>
