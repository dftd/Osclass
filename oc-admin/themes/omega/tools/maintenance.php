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


$maintenance = file_exists( osc_base_path() . '.maintenance');

function render_offset(){
  return 'row-offset';
}

function addHelp() {
  echo '<p>' . __('Show a "Site in maintenance mode" message to your users while you\'re updating your site or modifying its configuration.') . '</p>';
}
osc_add_hook('help_box','addHelp');

osc_add_hook('admin_page_header','customPageHeader');
function customPageHeader(){ ?>
  <h1><?php _e('Tools'); ?>
    <a href="#" class="btn ico ico-32 ico-help float-right"></a>
  </h1>
<?php
}

function customPageTitle($string) {
  return sprintf(__('Maintenance - %s'), $string);
}
osc_add_filter('admin_title', 'customPageTitle');

osc_current_admin_theme_path( 'parts/header.php' ); 
?>

<div id="backup-setting">
  <!-- settings form -->
  <div id="backup-settings">
    <h2 class="render-title"><?php _e('Maintenance'); ?></h2>
    <form>
      <fieldset>
        <div class="form-horizontal">
          <div class="form-row">
            <?php _e("While in maintenance mode, users can't access your website. Useful if you need to make changes on your website. Use the following button to toggle maintenance mode ON/OFF."); ?>
            <div class="help-box">
              <?php printf( __('Maintenance mode is: <strong>%s</strong>'), ($maintenance ? __('ON') : __('OFF') ) ); ?>
            </div>
          </div>
          <div class="form-actions no-padding">
            <input type="button" value="<?php echo ( $maintenance ? osc_esc_html( __('Disable maintenance mode') ) : osc_esc_html( __('Enable maintenance mode') ) ); ?>" onclick="window.location.href='<?php echo osc_admin_base_url(true); ?>?page=tools&amp;action=maintenance&amp;mode=<?php echo ( $maintenance ? 'off' : 'on' ) . "&amp;" . osc_csrf_token_url(); ?>';" class="btn btn-submit" />
          </div>
        </div>
      </fieldset>
    </form>
  </div>
  <!-- /settings form -->
</div>
<?php osc_current_admin_theme_path( 'parts/footer.php' ); ?>