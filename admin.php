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
      <h1><?php echo __('ZAWiW License', 'zawiw-license') ?></h1>
   <?php
	if(isset($_GET['site'])) {
		$site = $_GET['site'];
	} else $site = '';

	switch($site) {
	case 'viewLicenses':
		require_once dirname( __FILE__ ) .'/mgmt/viewLicenses.php';
		break;

	case 'alterBlogMedia':
		alterBlogMedia($_GET['path']);
		break;

	case 'saveBlogMedia':
		succeedChangeMedia($_POST['path'], $_POST['chooseLicense'], $_POST['author'], $_POST['origin']);
		break;

	case 'viewBlogMedia':
	default:
		viewBlogMedia();
	}
	?></div><?php
}
function viewBlogMedia()
{
?>
	<a class="button" id="licenseMgmt" href="?page=zawiwLicense&amp;site=viewLicenses" ><?= __('Licenses', 'zawiw-license')?></a>
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
	         <a href="?page=zawiwLicense&amp;site=alterBlogMedia&amp;path=<?php echo $path ?>"><img src="<?php echo $path ?>" alt="<?php echo basename($path) ?>" height="150" width="150"/></a>
	     </li>
         <?php
			break;

		default:
?>
            <li>
            	<a href="?page=zawiwLicense&amp;site=alterBlogMedia&amp;path=<?php echo $path ?>">
	            	<img src="http://mirror.forschendes-lernen.de/wp-includes/images/media/document.png" alt="<?php echo basename($path) ?>" />
					<br/>
					<?php echo $matches[1] ?>
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
      <img src="<?php echo $path ?>" alt="" class="" />
      <form class="alterMediaForm" method="post" action="?page=zawiwLicense&amp;site=saveBlogMedia" >
         <div>
	        <input type="hidden" name="path" value="<?php echo $path ?>" />
	        <label for="chooseLicense"><?php echo __('License:', 'zawiw-license') ?></label>
			<select  name="chooseLicense" id="chooseLicense">
               <?php  $licenses = getLicenses();
	foreach($licenses as $license) {
		$selected = $info != null && $info->license === $license->id ? "selected=\"selected\"" : "";
		echo "<option ". $selected ." value=\"". $license->id ."\">". $license->name ."</option>";
	}
?>
            </select>
         </div>
         <div><label for="author"><?php echo __('Author:', 'zawiw-license') ?></label>
            <input type="text" name="author" id="author" value="<?php echo $info == null ? "" : $info->author ?>" />
         </div>
         <div><label for="origin"><?php echo __('Source:', 'zawiw-license') ?></label>
            <input type="text" name="origin" id="origin" value="<?php echo $info == null ? "" : $info->origin ?>" />
         </div>
         <a class="button" id="cancel" href="?page=zawiwLicense&amp;site=viewBlogMedia"><?php echo __('Abort', 'zawiw-license') ?></a>
         <input class="button" type="submit" name="save" id="save" value="<?php echo __('Save', 'zawiw-license') ?>" />
      </form>
   </div>
<?php
}

function succeedChangeMedia($path, $licenseID, $author, $origin)
{
	$mediaInfo = getValidMediaInfo($path, $licenseID, $author, $origin);
	$license = getLicense($mediaInfo->license);
	$fileName = basename($mediaInfo->path);
	if(tryChangeMediaInfo($mediaInfo)) {
		displayUpdated(sprintf(__("Updated license of %s to %s."), $fileName, "<a target=\"_blank\" href=\"$license->link\">$license->name</a>"));
	} else displayError(sprintf(__("The provided license for %s is invalid.", 'zawiw-license'), $fileName));

	viewBlogMedia();
}
function importStylesheets()
{
	wp_enqueue_style('zawiwLicenseStyle', plugins_url( 'styles.css', __FILE__));
	wp_enqueue_style('licenseStyle', plugins_url( '/mgmt/license.css', __FILE__));
}
function importScripts()
{

}

function displayUpdated($msg)
{
?>
	<div class="updated">
		<p>
			<?php echo $msg ?>
		</p>
	</div>
	<?php
}
function displayError($msg)
{
?>
	<div class="error">
		<p>
			<?php echo $msg ?>
		</p>
	</div>
	<?php
}

?>
