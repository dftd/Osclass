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


$data = osc_get_preference('widget_data_update', 'osclass');
$prepare = json_decode($data, true);

if(isset($prepare['date']) && strtotime('-3 day') < strtotime($prepare['date']) && @$prepare['data'] <> '') {
  echo '<div class="widget-cache cached" title="' . osc_esc_html(sprintf(__('Data were cached on %s'), $prepare['date'])) . '">C</div>';
  $updatedata = $prepare['data'];
} else {
  echo '<div class="widget-cache notcached" title="' . osc_esc_html(__('Uncached data')) . '">L</div>';
  $updatedata = osc_file_get_contents('https://osclass-classifieds.com/api/latest_version.php');
  $updatedata  = json_decode($updatedata, true);

  osc_set_preference('widget_data_update', json_encode(array('date' => date('Y-m-d H:i:s'), 'data' => $updatedata)));
}

$s_version = $updatedata['version_string'];

$latest = true;
if($s_version <> '') {
  $check = version_compare2(OSCLASS_VERSION, $s_version);
  
  if($check == -1) {
    $latest = false;
  }
}
?>

<?php if($latest) { ?>
  <div class="row"><?php echo sprintf(__('You are using latest osclass version %s'), '<strong>' . OSCLASS_VERSION . '</strong>'); ?></div>
<?php } else { ?>
  <div class="row"><?php echo sprintf(__('There is osclass update available. Your version: %s, latest version: %s'), OSCLASS_VERSION, $s_version); ?></div>
<?php } ?>

<div class="row"><?php _e('Running website on latest version is important to keep your osclass fast and secure.'); ?></div>

<a href="https://osclass-classifieds.com/download" class="btn btn-submit"><?php echo __('Download osclass'); ?></a>