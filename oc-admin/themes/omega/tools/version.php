<?php if ( ! defined('OC_ADMIN')) exit('Direct access is not allowed.');
/*
 * Copyright 2020 OsclassPoint.com
 *
 * Osclass maintained & developed by OsclassPoint.com
 * you may not use this file except in compliance with the License.
 * You may download copy of Osclass at
 *
 *   https://osclass-classifieds.com/download
 *
 * Software is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */


$customPageHeader = static function () { 
  ?>
  <h1><?php echo sprintf(__('Osclass %s'), OSCLASS_VERSION); ?>
    <a href="#" class="btn ico ico-32 ico-help float-right"></a>
  </h1>
  <?php
};

osc_add_hook('admin_page_header', $customPageHeader);


$customPageTitle = static function ($string) {
  return sprintf(__('Osclass %s - %s'), OSCLASS_VERSION, $string);
};

osc_add_filter('admin_title', $customPageTitle);


unset($customPageTitle, $customPageHeader);

osc_current_admin_theme_path('parts/header.php');
?>

<div class="row-wrapper">
  <div class="widget-box">
    <div class="widget-box-title">
      <h3><?php echo sprintf(__('Osclass changelog up to v%s'), OSCLASS_VERSION); ?></h3>
    </div>
    <div class="widget-box-content">
      <ul class="version-list">
        <?php
          $content = preg_replace('/.+/', '<li>$0</li>',file_get_contents(ABS_PATH . 'CHANGELOG.txt'));
          $content = str_replace('<li>------------------------</li>', '', $content);
          $content = str_replace('<li>- ', '<li>', $content);
          $content = str_replace('<li>Osclass 10.', '<li class="version-head">Osclass 10.', $content);
          $content = str_replace('<li>Osclass 9.', '<li class="version-head">Osclass 9.', $content);
          $content = str_replace('<li>Osclass 8.', '<li class="version-head">Osclass 8.', $content);
          $content = str_replace('<li>Osclass 7.', '<li class="version-head">Osclass 7.', $content);
          $content = str_replace('<li>Osclass 6.', '<li class="version-head">Osclass 6.', $content);
          $content = str_replace('<li>Osclass 5.', '<li class="version-head">Osclass 5.', $content);
          $content = str_replace('<li>Osclass 4.', '<li class="version-head">Osclass 4.', $content);
          $content = str_replace('<li>Osclass 3.', '<li class="version-head">Osclass 3.', $content);
          $content = str_replace('<li>Osclass 2.', '<li class="version-head">Osclass 2.', $content);
          $content = str_replace('<li>Osclass 1.', '<li class="version-head">Osclass 1.', $content);

          echo $content;
        ?>
      </ul>
    </div>
  </div>
</div>

<?php osc_current_admin_theme_path('parts/footer.php'); ?>