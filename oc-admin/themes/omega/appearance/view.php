<?php if ( ! defined('OC_ADMIN')) exit('Direct access is not allowed.');
/*
 * Copyright 2020 OsclassPoint.com
 *
 * Osclass maintained & developed by OsclassPoint.com
 * you may not use this file except in compliance with the License.
 * You may download copy of Osclass at
 *
 *     https://osclass-classifieds.com/download
 *
 * Software is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */


$file = __get('file');
osc_add_hook('admin_page_header','customPageHeader');
function customPageHeader() { ?>
  <h1><?php echo osc_apply_filter('custom_appearance_title', __('Appearance')); ?></h1>
<?php
}

function customPageTitle($string) {
  return sprintf(__('Appearance - %s'), $string);
}
osc_add_filter('admin_title', 'customPageTitle');

osc_current_admin_theme_path( 'parts/header.php' ); 
?>

<!-- theme files -->
<div class="theme-files">
  <?php
    if(strpos($file, '../')===false && strpos($file, '..\\')==false && file_exists($file)) {
      require_once $file;
    }
  ?>
</div>
<!-- /theme files -->
<?php osc_current_admin_theme_path( 'parts/footer.php' ); ?>