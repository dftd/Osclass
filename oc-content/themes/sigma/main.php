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
osc_add_hook('header','sigma_follow_construct');
sigma_add_body_class('home');
?>

<?php osc_current_web_theme_path('header.php'); ?>

<div class="clear"></div>

<?php osc_goto_first_category(); ?>
<div id="home-cats">
  <h2><?php _e('All categories', 'sigma'); ?></h2>

  <div class="wrap">
    <?php while(osc_has_categories()) { ?>
      <a href="<?php echo osc_search_category_url(); ?>">
        <div class="icon" <?php if(osc_category_color() <> '') { ?>style="color:<?php echo osc_category_color(); ?>;"<?php } ?>>
          <i class="<?php echo (osc_category_icon() <> '' ? osc_category_icon() : 'far fa-share-square'); ?>"></i>
        </div>

        <strong><?php echo osc_category_name(); ?></strong>
      </a>
      

    <?php } ?>
  </div>
</div>

</div><!-- main -->
<div id="sidebar">
  <?php if( osc_get_preference('sidebar-300x250', 'sigma') != '') { ?>
    <div class="ads_300"><?php echo osc_get_preference('sidebar-300x250', 'sigma'); ?></div>
  <?php } ?>

  <div id="home-regs">
    <h2><?php _e('All locations', 'sigma'); ?></h2>

    <div class="wrap">
      <?php $regions = RegionStats::newInstance()->listRegions('%%%%', '>', 'i_num_items DESC'); ?>

      <?php $i = 1; ?>
      <?php foreach($regions as $r) { ?>
        <?php if($i <= 20) { ?>
          <div><a href="<?php echo osc_search_url(array('page' => 'search', 'sRegion' => $r['pk_i_id']));?>"><i class="fas fa-location-arrow"></i> <span><?php echo $r['s_name']; ?></span> <em>(<?php echo $r['i_num_items']; ?>)</em></a></div>
          <?php $i++; ?>
        <?php } ?>
      <?php } ?>

    </div>
  </div>
</div>

<div class="clear"><!-- do not close, use main clossing tag for this case -->
<?php if( osc_get_preference('homepage-728x90', 'sigma') != '') { ?>
  <div class="ads_728"><?php echo osc_get_preference('homepage-728x90', 'sigma'); ?></div>
<?php } ?>

<?php osc_current_web_theme_path('footer.php') ; ?>
