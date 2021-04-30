<?php
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


// meta tag robots
osc_add_hook('header','sigma_nofollow_construct');

sigma_add_body_class('user user-items');

function sidebar(){
  osc_current_web_theme_path('user-sidebar.php');
}
osc_add_hook('before-main','sidebar');

osc_current_web_theme_path('header.php') ;

$listClass = 'listing-list';
$buttonClass = '';
if(Params::getParam('ShowAs') == 'gallery'){
  $listClass = 'listing-grid';
  $buttonClass = 'active';
}
?>
<div class="list-header">
  <?php osc_run_hook('search_ads_listing_top'); ?>
  <h1><?php _e('My listings', 'sigma'); ?></h1>
  <?php if(osc_count_items() == 0) { ?>
    <p class="empty" ><?php _e('No listings have been added yet', 'sigma'); ?></p>
  <?php } else { ?>
  </div>
  <?php
    View::newInstance()->_exportVariableToView("listClass",$listClass);
    View::newInstance()->_exportVariableToView("listAdmin", true);
    osc_current_web_theme_path('loop.php');
  ?>
  <div class="clear"></div>
  <?php
  if(osc_rewrite_enabled()){
    $footerLinks = osc_search_footer_links();
  ?>
    <ul class="footer-links">
      <?php foreach($footerLinks as $f) { View::newInstance()->_exportVariableToView('footer_link', $f); ?>
        <?php if($f['total'] < 3) continue; ?>
        <li><a href="<?php echo osc_footer_link_url(); ?>"><?php echo osc_footer_link_title(); ?></a></li>
      <?php } ?>
    </ul>
  <?php } ?>
  <div class="paginate" >
    <?php echo osc_pagination_items(array(), Params::getParam('itemType')); ?>
  </div>
<?php } ?>
<?php osc_current_web_theme_path('footer.php') ; ?>