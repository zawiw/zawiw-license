<?php
require_once dirname( __FILE__ ) .'/../dbfunctions.php';
require_once dirname( __FILE__ ) .'/licenseFunctions.php';

if(isset($_GET['action']) && $_GET['action'] == 'delete'){
   // in dbfunctions
   deleteLicense($_GET['id']);
}
#var_dump(getLicenses());
$licenses = getLicenses();
array_shift($licenses);
?>
<hr>
<div class="newLicense">
<h1><?= __('Add new license', 'zawiw-license')?></h1>
<div id="license_new">
   <form>
      <label for="name"><?= __('Name:', 'zawiw-license')?></label>
      <input type="text" name="name" value="" />
      <label for="link"><?= __('Link:', 'zawiw-license')?></label>
      <input type="text" name="link" value="" />
      <input type="submit" class="button" value="<?= __('Save', 'zawiw-license')?>" />
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
         <form>
            <label for="name"><?= __('Name:', 'zawiw-license')?></label>
            <input type="text" name="name" value="<?= $license->name ?>" />
            <label for="link"><?= __('Link:', 'zawiw-license')?></label>
            <input type="text" name="link" value="<?= $license->link ?>" />
            <input type="hidden" name="id" value="<?= $license->id ?>" />
            <input type="submit" class="button" value="<?= __('Save', 'zawiw-license')?>" />
            <a class="button" href="?page=zawiwLicense&amp;site=viewLicenses&amp;action=delete&amp;id=<?= $license->id ?>"><?= __('Delete', 'zawiw-license')?></a>
         </form>
      </div>
      <hr>
      <?php
   }
   ?>
</div>
