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


//customize Head
function customHead() { }
osc_add_hook('admin_header','customHead', 10);

function addHelp() {
  echo '<p>' . __("Check your debug/error log settings and debug output.") . '</p>';
}

osc_add_hook('help_box','addHelp');


function customPageHeader(){ 
  ?> 
  <h1><?php _e('Debug/Error log'); ?>
    <a href="#" class="btn ico ico-32 ico-help float-right"></a>
  </h1>
  <?php
}

osc_add_hook('admin_page_header','customPageHeader');


function customPageTitle($string) {
  return sprintf(__('Tools - %s'), $string);
}

osc_add_filter('admin_title', 'customPageTitle');

osc_current_admin_theme_path( 'parts/header.php' );

$log_file = '';
$log_file_url = '';
$limit_lines = 1000;

if(file_exists(CONTENT_PATH . 'debug.log')) {
  $log_file_url = osc_base_url() . 'oc-content/debug.log';
  
  $i = 0;
  $log_file = '';
  $handle = fopen(CONTENT_PATH . 'debug.log', "r");
  while(!feof($handle)){
    $log_file .= fgets($handle);
    $i++;
    
    if($i > $limit_lines) {
      $log_file .= '<br/>' . sprintf(__('First %s lines shown, download log file to see full content'), $limit_lines);
      break;
    }
  }

  fclose($handle);
}
?>

<div class="grid-row grid-40">
  <div class="row-wrapper">
    <div class="widget-box debg">
      <div class="widget-box-title"><h3><i class="fa fa-gear"></i> <?php _e('Debug/Error log settings'); ?></h3></div>
      <div class="widget-box-content">
        <p><strong><?php _e('PHP error log'); ?>:</strong> <span><?php if(defined('OSC_DEBUG') && OSC_DEBUG) { echo '<i class="fa fa-check"></i>' . __('Enabled'); } else { echo '<i class="fa fa-times"></i>' . __('Disabled'); }; ?></span></p>
        <p><strong><?php _e('PHP errors output to file'); ?>:</strong> <span><?php if(defined('OSC_DEBUG_LOG') && OSC_DEBUG_LOG) { echo '<i class="fa fa-check"></i>' . __('Enabled'); } else { echo '<i class="fa fa-times"></i>' . __('Disabled'); }; ?></span></p>
        <p><strong><?php _e('Database debug mode'); ?>:</strong> <span><?php if(defined('OSC_DEBUG_DB') && OSC_DEBUG_DB) { echo '<i class="fa fa-check"></i>' . __('Enabled'); } else { echo '<i class="fa fa-times"></i>' . __('Disabled'); }; ?></span></p>
      </div>
    </div>
    
    <div class="widget-box debg">
      <div class="widget-box-title"><h3><i class="fa fa-gear"></i> <?php _e('Enable logs'); ?></h3></div>
      <div class="widget-box-content">
        <p><?php _e('You can enable error/debug logs in config.php (located in root directory) by adding following lines'); ?>:</p>
        <p><strong class="code">define(OSC_DEBUG, true);</strong> - <span><?php _e('enable PHP debugging'); ?></span></p>
        <p><strong class="code">define(OSC_DEBUG_LOG, true);</strong> - <span><?php _e('stores PHP debug into log file'); ?></span></p>
        <p><strong class="code">define(OSC_DEBUG_DB, true);</strong> - <span><?php _e('enable DB debugging'); ?></span></p>
      </div>
    </div>
  </div>
</div>

<div class="grid-row grid-60">
  <div class="row-wrapper">
    <div class="widget-box debg">
      <div class="widget-box-title">
        <h3>
          <i class="fa fa-database"></i> <?php _e('Debug log file'); ?>
          
          <?php if($log_file_url <> '') { ?>
            <a href="<?php echo $log_file_url; ?>" target="_blank" class="btn float-right" style="margin-top: -4px;"><?php _e('Download'); ?></a>
          <?php } ?>
        </h3>
      </div>
      <div class="widget-box-content dbgfl">
        <?php if($log_file <> '') { ?>
          <div class="dbgfl">
            <div class="debug-file"><?php echo $log_file; ?></div>
          </div>
        <?php } else { ?>
          <div class="empty"><?php echo sprintf(__('Debug log file is empty or does not exists, it should be located in %s folder.'), '<strong>oc-content</strong>'); ?></div>
        <?php } ?>
      </div>
    </div>
    
  </div>
</div>
<?php osc_current_admin_theme_path( 'parts/footer.php' ); ?>