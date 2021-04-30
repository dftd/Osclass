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
<div class="actions">
  <a href="#" data-bclass-toggle="display-filters" class="resp-toogle show-menu-btn btn btn-secondary"><?php _e('Display menu','sigma'); ?></a>
</div>

<div id="sidebar" class="fixed-layout">
  <div class="fixed-close"><i class="fas fa-times"></i></div>
  <?php echo osc_private_user_menu( get_user_menu() ); ?>
</div>

<div id="dialog-delete-account" title="<?php echo osc_esc_html(__('Delete account', 'sigma')); ?>" style="display:none;"><?php _e('Are you sure you want to delete your account?', 'sigma'); ?></div>