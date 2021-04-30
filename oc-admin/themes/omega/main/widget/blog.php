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


$data = osc_get_preference('widget_data_blog', 'osclass');
$prepare = json_decode($data, true);

if(isset($prepare['date']) && strtotime('-3 day') < strtotime($prepare['date']) && @$prepare['data'] <> '') {
  echo '<div class="widget-cache cached" title="' . osc_esc_html(sprintf(__('Data were cached on %s'), $prepare['date'])) . '">C</div>';
  $articles = $prepare['data'];
} else {
  echo '<div class="widget-cache notcached" title="' . osc_esc_html(__('Uncached data')) . '">L</div>';
  $articles = osc_file_get_contents(osc_market_url('blog'));
  $articles  = json_decode($articles, true);

  osc_set_preference('widget_data_blog', json_encode(array('date' => date('Y-m-d H:i:s'), 'data' => $articles)));
}

?>

<?php if(!is_array($articles) || count($articles) <= 0) { ?>
  <div class="empty"><?php _e('No articles has been found'); ?></div>
<?php } else { ?>
  <?php foreach($articles as $a) { ?>
    <div class="row">
      <a href="<?php echo $a['link']; ?>"><?php echo $a['title']; ?></a>
      <div class="date"><?php echo osc_format_date($a['pub_date'], 'd. M Y'); ?></div>
      <div class="desc"><?php echo osc_highlight($a['short_description'], 135); ?></div>
    </div>
  <?php } ?>
<?php } ?>

<div class="foot">
  <a href="https://osclasspoint.com/blog/home"><?php _e('More news'); ?></a>
</div>