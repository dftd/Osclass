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

    bender_add_body_class('user user-items');
    osc_add_hook('before-main','sidebar');
    function sidebar(){
        osc_current_web_theme_path('user-sidebar.php');
    }
    osc_current_web_theme_path('header.php') ;

    $listClass = '';
    $buttonClass = '';
    if( Params::getParam('ShowAs') === 'gallery'){
        $listClass = 'listing-grid';
        $buttonClass = 'active';
    }
?>
<div class="list-header">
    <?php osc_run_hook('search_ads_listing_top'); ?>
    <h1><?php _e('My listings', 'bender'); ?></h1>
    <?php if(osc_count_items() == 0) { ?>
        <p class="empty" ><?php _e('No listings have been added yet', 'bender'); ?></p>
    <?php } else { ?>
        <div class="actions">
            <span class="doublebutton <?php echo $buttonClass; ?>">
                <a href="<?php echo osc_user_list_items_url(); ?>?ShowAs=list" class="list-button" data-class-toggle="listing-grid" data-destination="#listing-card-list"><span>Lista</span></a>
                <a href="<?php echo osc_user_list_items_url(); ?>?ShowAs=gallery" class="grid-button" data-class-toggle="listing-grid" data-destination="#listing-card-list"><span>Grid</span></a>
            </span>
        </div>
    </div>
    <?php
        View::newInstance()->_exportVariableToView( 'listClass' , $listClass);
        View::newInstance()->_exportVariableToView( 'listAdmin' , true);
        osc_current_web_theme_path('loop.php');
    ?>
    <div class="clear"></div>
    <?php
    if(osc_rewrite_enabled()){
	    try {
		    $footerLinks = osc_search_footer_links();
	    } catch ( Exception $e ) {
	    }
	    ?>
        <ul class="footer-links">
            <?php foreach($footerLinks as $f) { View::newInstance()->_exportVariableToView('footer_link', $f); ?>
	            <?php if ( $f[ 'total' ] < 3 ) {
		            continue;
	            } ?>
                <li><a href="<?php try {
		                echo osc_footer_link_url();
	                } catch ( Exception $e ) {
	                } ?>"><?php try {
			                echo osc_footer_link_title();
		                } catch ( Exception $e ) {
		                } ?></a></li>
            <?php } ?>
        </ul>
    <?php } ?>
    <div class="paginate" >
        <?php echo osc_pagination_items(); ?>
    </div>
<?php } ?>
<?php osc_current_web_theme_path('footer.php') ; ?>
