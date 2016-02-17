<?php
require_once dirname( __FILE__ ) .'/../dbfunctions.php';
require_once dirname( __FILE__ ) .'/../admin.php';

if (!current_user_can(EditLicensesCapability)) {
	displayError(__('You don\'t have enough rights.', 'zawiw-license'));
} else {
if(isset($_GET['action']) && $_GET['action'] == 'delete'){
   // in dbfunctions
   deleteLicense($_GET['id']);
}
if(isset($_POST['submitLicense']) && isset($_POST['name']) && isset($_POST['link'])) {
   if(empty($_POST['submitLicense']) || empty($_POST['name']) || empty($_POST['link'])) {
      displayError(__('Error saving license: minimum one field is empty', 'zawiw-license'));
   } else {
      // in dbfunctions
      createLicense($_POST['name'], $_POST['link']);
      displayUpdated(__('New license saved successfully', 'zawiw-license'));
   }
}
if(isset($_POST['alterLicense']) && isset($_POST['name']) && isset($_POST['link'])) {
   if(empty($_POST['alterLicense']) || empty($_POST['name']) || empty($_POST['link']) || empty($_POST['id'])){
      displayError(__('Error saving license: minimum one field is empty', 'zawiw-license'));
   } else {
      $license = (object) array(
         'name' => $_POST['name'],
         'link' => $_POST['link'],
         'id' => $_POST['id']
      );
      // in dbfunctions
      saveLicense($license);
   }
}
#var_dump(getLicenses());
$licenses = getLicenses();
array_shift($licenses);
?>
<hr>
<div class="newLicense">
<h1><?= __('Add new license', 'zawiw-license')?></h1>
<div id="license_new">
   <form method="post">
      <label for="name"><?= __('Name:', 'zawiw-license')?></label>
      <input type="text" name="name" value="" />
      <label for="link"><?= __('Link:', 'zawiw-license')?></label>
      <input type="text" name="link" value="" />
      <input type="submit" name="submitLicense" class="button" value="<?= __('Save', 'zawiw-license')?>" />
   </form>
</div>
</div>
<hr>
<div class="currentLicenses">
<h1><?= __('Current licenses', 'zawiw-license')?></h1>
   <?php
   foreach ($licenses as $license) {
      ?>
      <div id="license_<?= $license->id ?>" class="expandElem">
         <form method="post">
            <label for="name"><?= __('Name:', 'zawiw-license')?></label>
            <input type="text" name="name" value="<?= $license->name ?>" />
            <label for="link"><?= __('Link:', 'zawiw-license')?></label>
            <input type="text" name="link" value="<?= $license->link ?>" />
            <input type="hidden" name="id" value="<?= $license->id ?>" />
            <input type="submit" name="alterLicense" class="button" value="<?= __('Save', 'zawiw-license')?>" />
            <a class="button" href="?page=zawiwLicense&amp;site=viewLicenses&amp;action=delete&amp;id=<?= $license->id ?>"><?= __('Delete', 'zawiw-license')?></a>
         </form>
      </div>
   </br>
      <?php
   }
   ?>
</div>
<?php

}