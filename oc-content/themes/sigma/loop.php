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

<?php
$loopClass = 'listing-list';
$type = 'items';
if(View::newInstance()->_exists('listType')){
    $type = View::newInstance()->_get('listType');
}
if(View::newInstance()->_exists('listClass')){
  $loopClass = View::newInstance()->_get('listClass');
}

if(trim($loopClass) == '' || trim($loopClass) == 'premium-list' || trim($loopClass) == 'listing-list') {
  $loopClass = 'listing-list';
} else {
  $loopClass = 'listing-grid';
}
?>
<ul class="listing-card-list <?php echo $loopClass; ?>" id="listing-card-list">
    <?php
        $i = 0;

        if($type == 'latestItems'){
            while ( osc_has_latest_items() ) {
                $class = '';
                if($i%3 == 0){
                    $class = 'first';
                }
                sigma_draw_item($class);
                $i++;
            }
        } elseif($type == 'premiums'){
            while ( osc_has_premiums() ) {
                $class = '';
                if($i%3 == 0){
                    $class = 'first';
                }
                sigma_draw_item($class,false,true);
                $i++;
                if($i == 3){
                    break;
                }
            }
        } else {
            search_ads_listing_top_fn();
            while(osc_has_items()) {
                $i++;
                $class = false;
                if($i%4 == 0){
                    $class = 'last';
                }
                $admin = false;
                if(View::newInstance()->_exists("listAdmin")){
                    $admin = true;
                }

                sigma_draw_item($class,$admin);

                if(sigma_show_as()=='gallery') {
                    if($i%8 == 0){
                        osc_run_hook('search_ads_listing_medium');
                    }
                } else if(sigma_show_as()=='list') {
                    if($i%6 == 0){
                        osc_run_hook('search_ads_listing_medium');
                    }
                }
          }
        }
    ?>
</ul>