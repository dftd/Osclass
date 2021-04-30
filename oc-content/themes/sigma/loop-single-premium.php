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

?>

<?php $size = explode('x', osc_thumbnail_dimensions()); ?>
<li class="<?php osc_run_hook("highlight_class"); ?>listing-card <?php echo $class . ' premium'; ?>">
  <?php if( osc_images_enabled_at_items() ) { ?>
    <?php if(osc_count_premium_resources()) { ?>
      <a class="listing-thumb" href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
    <?php } else { ?>
      <a class="listing-thumb" href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
    <?php } ?>
  <?php } ?>

  <div class="listing-detail">
    <div class="listing-cell">
      <div class="listing-data">
        <div class="listing-basicinfo">
          <a href="<?php echo osc_premium_url() ; ?>" class="title" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><?php echo osc_premium_title() ; ?></a>
          <div class="listing-attributes">
            <?php if( osc_price_enabled_at_items() ) { ?><span class="currency-value"><?php echo osc_format_price(osc_premium_price(),osc_premium_currency_symbol()); ?></span><?php } ?>

            <div class="listing-details">
              <span class="category"><?php echo osc_premium_category() ; ?></span>
              <span class="location"><?php echo osc_premium_city(); ?> <?php if( osc_premium_region()!='' ) { ?> (<?php echo osc_premium_region(); ?>)<?php } ?></span> 
              <span class="date"><?php echo osc_format_date(osc_premium_pub_date()); ?></span>
            </div>
          </div>

          <div class="desc"><?php echo osc_highlight( osc_premium_description() ,250) ; ?></div>
        </div>
        
        <?php if(osc_premium_user_id() > 0 && osc_premium_user_id() == osc_logged_user_id()){ ?>
          <span class="admin-options">
            <a href="<?php echo osc_premium_edit_url(); ?>" rel="nofollow"><?php _e('Edit item', 'sigma'); ?></a>
            <a class="delete" onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', 'sigma')); ?>')" href="<?php echo osc_premium_delete_url();?>" ><?php _e('Delete', 'sigma'); ?></a>
          </span>
        <?php } ?>
      </div>
    </div>
  </div>
</li>