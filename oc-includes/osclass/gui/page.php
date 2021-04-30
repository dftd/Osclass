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
    osc_add_hook('header','bender_nofollow_construct');

    bender_add_body_class('page');
    osc_current_web_theme_path('header.php') ;
?>
<h1><?php echo osc_static_page_title(); ?></h1>
<?php echo osc_static_page_text(); ?>
<?php osc_current_web_theme_path('footer.php') ; ?>