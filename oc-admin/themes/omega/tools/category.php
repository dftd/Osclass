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


function customPageHeader(){ 
  ?>
  <h1><?php _e('Tools'); ?></h1>
  <?php
}

osc_add_hook('admin_page_header','customPageHeader');


function customPageTitle($string) {
  return sprintf(__('Category stats - %s'), $string);
}

osc_add_filter('admin_title', 'customPageTitle');

osc_current_admin_theme_path( 'parts/header.php' ); 
?>

<div id="backup-setting">
  <!-- settings form -->
  <div id="backup-settings">
    <h2 class="render-title"><?php _e('Category stats'); ?></h2>
    <p><?php _e('You can recalculate stats by category, useful if the stats seem to be incorrect.'); ?>.</p>
    <form id="backup_form" name="backup_form" action="<?php echo osc_admin_base_url(true); ?>" method="post">
      <input type="hidden" name="page" value="tools" />
      <input type="hidden" name="action" value="category_post" />
      <fieldset>
        <div class="form-horizontal">
          <div class="form-actions no-padding">
            <input type="submit" id="backup_save" value="<?php echo osc_esc_html( __('Calculate category stats')); ?>" class="btn btn-submit" />
          </div>
        </div>
      </fieldset>
    </form>
  </div>
  <!-- /settings form -->
</div>
<?php osc_current_admin_theme_path( 'parts/footer.php' ); ?>