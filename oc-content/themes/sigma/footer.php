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
</div>
<?php osc_run_hook('after-main'); ?>
</div>
</section>

<?php osc_show_widgets('footer');?>

<footer>
  <div class="wrapper">
    <div class="box">
      <a href="<?php echo osc_contact_url(); ?>"><?php _e('Contact', 'sigma'); ?></a>

      <?php
        osc_reset_static_pages();
        while( osc_has_static_pages() ) { 
      ?>
        <a href="<?php echo osc_static_page_url(); ?>"><?php echo osc_static_page_title(); ?></a>
      <?php } ?>

      <div class="clear"></div>

      <?php if( (!defined('MULTISITE') || MULTISITE==0) && osc_get_preference('footer_link', 'sigma') !== '0') {
        echo '<div class="copy">' . sprintf(__('Powered by <a title="Osclass classifieds script" href="%s">best classifieds scripts</a> osclass'), 'https://osclass-classifieds.com') . '</div>';
      } ?>

      <?php if ( osc_count_web_enabled_locales() > 1) { ?>
        <div class="language">
          <?php osc_goto_first_locale(); ?>
          <?php while ( osc_has_web_enabled_locales() ) { ?>
            <a id="<?php echo osc_locale_code(); ?>" href="<?php echo osc_change_language_url ( osc_locale_code() ); ?>"><?php echo osc_locale_name(); ?></a>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </div>

  <?php osc_run_hook('footer'); ?>
</footer>

<link href="<?php echo osc_assets_url('css/jquery-ui/jquery-ui.css'); ?>" rel="stylesheet" type="text/css" />

</body>
</html>