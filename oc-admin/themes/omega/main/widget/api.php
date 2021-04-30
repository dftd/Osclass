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

$api_key = osc_get_preference('osclasspoint_api_key', 'osclass'); 
$data = osc_get_preference('widget_data_api', 'osclass');
$prepare = json_decode($data, true);

if($api_key != '') {
  if(isset($prepare['date']) && strtotime('-3 day') < strtotime($prepare['date']) && @$prepare['data'] <> '' && @$prepare['api_key'] == $api_key) {
    echo '<div class="widget-cache cached" title="' . osc_esc_html(sprintf(__('Data were cached on %s'), $prepare['date'])) . '">C</div>';
    $apidata = $prepare['data'];
  } else {
    echo '<div class="widget-cache notcached" title="' . osc_esc_html(__('Uncached data')) . '">L</div>';
    $apidata = osc_file_get_contents(osc_market_url('validate_api_key'));
    $apidata = json_decode($apidata, true); 

    osc_set_preference('widget_data_api', json_encode(array('date' => date('Y-m-d H:i:s'), 'api_key' => $api_key, 'data' => $apidata)));
  }
}
?>
  
<?php if($api_key == '') { ?>
  <div class="row"><?php _e('API key has not been defined'); ?></div>
  <div class="row"><?php echo sprintf(__('In order to be able to download data from OsclassPoint, you must define your API key in %s section'), '<a href="' . osc_admin_base_url(true) . '?page=settings">' . __('Settings > General > Software updates') . '</a>'); ?>.</div>
<?php } else { ?>
  <?php if(isset($apidata['error']) && $apidata['error'] <> '') { ?>
    <div class="row"><?php echo sprintf(_m('API key validation error: %s'), $apidata['error']); ?>.</div>
  <?php } else { ?>
    <div class="row"><i class="fa fa-check-circle-o"></i> <?php _e('API key is valid, automatic updates & market functions are available'); ?>.</div>
  <?php } ?>
<?php } ?>