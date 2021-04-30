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


function render_offset(){
  return 'row-offset';
}


function addHelp() {
  echo '<p>' . __("Upload registers from other Osclass installations or upload new geographic information to your site. <strong>Be careful</strong>: don’t use this option if you're not 100% sure what you're doing.") . '</p>';
}

osc_add_hook('help_box','addHelp');


function customPageHeader(){ 
  ?>
  <h1><?php _e('Tools'); ?>
    <a href="#" class="btn ico ico-32 ico-help float-right"></a>
  </h1>
  <?php
}

osc_add_hook('admin_page_header','customPageHeader');


function customPageTitle($string) {
  return sprintf(__('Import - %s'), $string);
}

osc_add_filter('admin_title', 'customPageTitle');

osc_current_admin_theme_path( 'parts/header.php' ); 
?>

<!-- settings form -->
<div id="backup-settings">
  <h2 class="render-title"><?php _e('Import'); ?></h2>
  <form id="backup_form" name="backup_form" action="<?php echo osc_admin_base_url(true); ?>" enctype="multipart/form-data" method="post">
    <input type="hidden" name="page" value="tools" />
    <input type="hidden" name="action" value="import_post" />
    <fieldset>
      <div class="form-horizontal">
        <div class="form-row">
          <div class="form-label"><?php _e('File (.sql)'); ?></div>
          <div class="form-controls">
           <input type="file" name="sql" id="sql" />
          </div>
        </div>
        <div class="form-actions">
          <input type="submit" value="<?php echo osc_esc_html( __('Import data') ); ?>" class="btn btn-submit" />
        </div>
      </div>
    </fieldset>
  </form>
</div>
<!-- /settings form -->
<?php osc_current_admin_theme_path( 'parts/footer.php' ); ?>