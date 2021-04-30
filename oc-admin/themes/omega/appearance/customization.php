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

function addHelp() {
  echo '<p>' . __('Enter your custom CSS code to modify design of your theme. Code will not be affected by theme or osclass updates. Code will be inserted into footer between &lt;style&gt;&lt;/style&gt; tags.') . '</p>';
}

osc_add_hook('help_box','addHelp');


function customPageHeader(){ 
  ?>
  <h1><?php _e('Appearance'); ?>
    <a href="#" class="btn ico ico-32 ico-help float-right"></a>
  </h1>
  <?php
}

osc_add_hook('admin_page_header','customPageHeader');


function customPageTitle($string) {
  return sprintf(__('Customization - %s'), $string);
}

osc_add_filter('admin_title', 'customPageTitle');


osc_current_admin_theme_path('parts/header.php'); 
?>

<div id="customization-setting">
  <!-- settings form -->
  <div id="customization-settings" class="form-horizontal">
    <h2 class="render-title"><?php _e('Theme Customization'); ?></h2>
    <ul id="error_list"></ul>
    <form name="settings_form" action="<?php echo osc_admin_base_url(true); ?>" method="post">
      <input type="hidden" name="page" value="appearance" />
      <input type="hidden" name="action" value="customization_update" />
      <fieldset>
        <div class="form-horizontal">
          <div class="form-row">
            <div class="form-label"><?php _e('Your CSS'); ?></div>
            <div class="form-controls css">
              <textarea type="text" class="" name="customCss"><?php echo osc_get_preference('custom_css'); ?></textarea>
              <span class="help-box"><?php _e('Do not enter &lt;style&gt;&lt;/style&gt; tags. You may check following CSS guide:'); ?> <a target="_blank" ref="noopener norefer nofollow" href="https://www.w3schools.com/css/">https://www.w3schools.com/css/</a></span>
            </div>
          </div>
        </div>
        
        <div class="form-horizontal">
          <div class="form-row">
            <div class="form-label"><?php _e('Your HTML code'); ?></div>
            <div class="form-controls html">
              <textarea type="text" class="" name="customHtml"><?php echo osc_get_preference('custom_html'); ?></textarea>
              <span class="help-box"><?php _e('You may enter any HTML or JavaScript code. Code will be added into footer. Do not add PHP code.'); ?></span>
            </div>
          </div>
        </div>
      </fieldset>

      <div class="clear"></div>
      
      <div class="form-actions">
        <input type="submit" id="save_changes" value="<?php echo osc_esc_html( __('Save changes') ); ?>" class="btn btn-submit" />
      </div>
    </form>
  </div>
</div>

<?php osc_current_admin_theme_path( 'parts/footer.php' ); ?>