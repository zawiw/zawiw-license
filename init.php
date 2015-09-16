<?php
require_once ABSPATH . 'wp-admin/includes/upgrade.php';
require_once dirname( __FILE__ ) .'/dbfunctions.php';
function licenseActivation()
{
   createDatabase(genTablePrefix());
   seedMediaLicense(genTablePrefix());
   seedBlogMedia(genTablePrefix());
}
function licenseDeactivation()
{
   global $wpdb;
   $blogPrefix = genTablePrefix();
   foreach (array('blogMedia', 'mediaLicense') as $table)
   {
      $deleteQuery = 'DROP TABLE '. $blogPrefix . $table;
      $wpdb->query($deleteQuery);
   }
}
function createDatabase($blogPrefix)
{
   $createBlogMediaQuery = 'CREATE TABLE ' . $blogPrefix . 'blogMedia (
      path varchar(255) NOT NULL,
      license int(20),
      author TEXT,
      origin TEXT,
      UNIQUE KEY  (path)
   ) DEFAULT CHARACTER SET=utf8;';
   dbDelta($createBlogMediaQuery);
   $createMediaLicenseQuery = 'CREATE TABLE ' . $blogPrefix .'mediaLicense (
      id int(20) NOT NULL AUTO_INCREMENT,
      name TEXT,
      link TEXT,
      UNIQUE KEY  (id)
   ) DEFAULT CHARACTER SET=utf8;';
   dbDelta($createMediaLicenseQuery);
}
/*
 * enter seeds for licenses
*/
function seedMediaLicense($blogPrefix)
{
   global $wpdb;
   $seeds = array(
      array(
         'id' => '1',
         'name' => 'keine Lizenz gewählt',
         'link' => ''
      ),
      array(
         'name' => 'CC BY-SA 2.5',
         'link' => 'http://creativecommons.org/licenses/by-sa/2.5/'
      ),
      array(
         'name' => 'CC BY 2.0',
         'link' => 'http://creativecommons.org/licenses/by/2.0/'
      )
   );
   foreach ($seeds as $s) {
      $wpdb->insert(
         $blogPrefix . 'mediaLicense', $s);
   }
}
function seedBlogMedia($blogPrefix)
{
   global $wpdb;
   $wpdb->insert(
      $blogPrefix . 'blogMedia',
      array(
         'path' => '/wp-content/uploads/sites/19/2015/09/openldap.png',
         'license' => '1',
         'author' => 'schorsch',
         'origin' => 'insaneBrain!!!!1111elf'
      )
   );
}
?>
