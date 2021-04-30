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


function osc_check_demo_login_data($type = 'email') {
  if((defined('DEMO_PLUGINS') && DEMO_PLUGINS === true) || (defined('DEMO_THEMES') && DEMO_THEMES === true) || (defined('DEMO') && DEMO === true)) {
    $demo_user = User::newInstance()->findByUserName('demo');
    
    if($demo_user !== false) {
      if($type == 'email') {
        return 'demo@demo.com';
      } else if ($type == 'username') {
        return 'demo';
      } else if ($type == 'password') {
        return 'demo123';
      }
    }
  }
  
  return '';
}


function osc_custom_css_footer() {
  if(trim(osc_get_preference('custom_css')) <> '') {
    echo '<style>' . osc_get_preference('custom_css') . '</style>' . PHP_EOL;
  }
}

osc_add_hook('footer', 'osc_custom_css_footer', 10);


function osc_custom_html_footer() {
  if(trim(osc_get_preference('custom_html')) <> '') {
    echo osc_get_preference('custom_html') . PHP_EOL;
  }
}

osc_add_hook('footer', 'osc_custom_html_footer', 10);


function osc_admin_toolbar_in_front() {
  if(osc_is_admin_user_logged_in() && osc_admin_toolbar_front_enabled()) {
    osc_admin_toolbar_in_front_css();
    
    osc_add_hook('add_admin_toolbar_menus', 'osc_admin_toolbar_back', 0);
    osc_add_hook('add_admin_toolbar_menus', 'osc_admin_toolbar_logged_user', 0);
    osc_add_hook('add_admin_toolbar_menus', 'osc_admin_toolbar_edit_item', 0);
    osc_add_hook('add_admin_toolbar_menus', 'osc_admin_toolbar_edit_page', 0);
    osc_add_hook('add_admin_toolbar_menus', 'osc_admin_toolbar_edit_user', 0);

    _osc_admin_toolbar_init(true);
    AdminToolbar::newInstance()->render(true);
  }
}

osc_add_hook('header', 'osc_admin_toolbar_in_front', 1);


function osc_admin_toolbar_in_front_css() {
  if(osc_is_admin_user_logged_in() && osc_admin_toolbar_front_enabled()) {
    $admin_scheme = (osc_get_preference('admin_color_scheme') <> '' ? osc_get_preference('admin_color_scheme') : 'default');
  ?>
  <style>
    body {margin-top:34px!important;}
    #header-admin {display:block;position:fixed;overflow:hidden;z-index:999999;top:0;left:0;height:34px;padding:0 105px 0 3px;border:none;line-height:16px;width: 100%; background-color: #000; color: #fff;font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif; font-size: 14px; line-height: 18px;}
    #header-admin a {color:#fff;}
    #header-admin a .circle {font-style: normal; color: #fff; min-width: 18px; box-sizing: border-box; padding: 0 4px; float: left; margin: 1px 4px 0 0; text-align: center; height: 17px; line-height: 17px; font-size: 11px; border-radius: 5px; background:rgba(255,255,255,0.4); }
    #header-admin .header-wrapper > div a {color:#eee;float:left;text-decoration:none;position: relative; border: none!important; padding: 5px 6px; margin: 3px 2px 3px 0; height: 28px; font-size: 13px; line-height: 18px;}
    #header-admin .header-wrapper > div {display:inline-block;}
    #header-admin .header-wrapper > div#osc_toolbar_demo {display:none;}
    #header-admin .header-wrapper > div a:hover, #header-admin .header-wrapper > div a.active {color:#00b9eb;background:#444;}
    #header-admin #osc_toolbar_logout a:before {display:none;}
    #header-admin #osc_toolbar_logout a:hover {background:#444;}
    #header-admin #osc_mt_demo {display:none;}
    <?php if(in_array(osc_current_web_theme(), array('gamma', 'beta', 'starter'))) { ?>body header, body #header-bar {top:34px;}<?php } ?>
   
    @media screen and (min-width: 768px) {
      #header-admin #osc_toolbar_logout {position:absolute;right:10px;top:0;}
      #header-admin #osc_toolbar_logout a {display:inline-block;margin: 3px 0; line-height: 18px; padding: 5px 6px 5px 8px;border-radius:0; height: 28px; border: none; background: transparent; font-size: 13px;}
      #header-admin #osc_toolbar_back, #header-admin #osc_toolbar_logged, #header-admin #osc_toolbar_edititem, #header-admin #osc_toolbar_editpage {margin-right:5px;}
      #header-admin #osc_toolbar_back i.fa {float: left; line-height: 19px; width: 20px; font-size: 16px; margin-right: 3px;}
    }
    
    @media screen and (max-width: 767px) {
      body {margin-top:46px!important;}
      #header-admin .header-wrapper > div {display:none;}
      #header-admin #osc_toolbar_back, #header-admin #osc_toolbar_logged, #header-admin #osc_toolbar_editpage, #header-admin #osc_toolbar_edititem, #header-admin #osc_toolbar_logout {display:block;}
      #header-admin #osc_toolbar_mobilemenu:not(.is-empty) {display:block!Important;}
      #header-admin #osc_toolbar_mobilemenu a:after { content: ""; position: absolute; right: 5px; top: 5px; width: 8px; height: 8px; border-radius: 100px; z-index: 2; background: #00b9eb; }
      #header-admin #osc_toolbar_logout {position:absolute;top:0;right:0;}
      #header-admin {padding:0 3px;}
      #header-admin {height:46px;overflow:visible;}
      #header-admin .header-wrapper > div a {height:46px;margin:0;width:46px;padding:0;color:#aaa;}
      #header-admin .header-wrapper > div a i.fa {line-height:46px;font-size:22px;text-align:center;width:100%;}
      #header-admin .header-wrapper > div a i + span {display:none;}
      body header, body #header-admin:not(.navbar), body.header {top:46px;}
      #header-admin .osc_mobile_list { position: absolute; left: 0; top: 46px; background: #444; width: 100%; margin: 0; padding:15px 15px 5px 15px; z-index: 9; }
      #header-admin .osc_mobile_list li { display: block; width: 100%; clear: both; float: left; margin: 0 0 10px 0; }
      #header-admin .osc_mobile_list li a .circle { margin: 0px 5px 0 0; }
      #header-admin #osc_mt_back, #header-admin #osc_mt_logged, #header-admin #osc_mt_editpage, #header-admin #osc_mt_edituser, #header-admin #osc_mt_edititem, #header-admin #osc_mt_logout {display:none;}
    }
    
    <?php if(in_array($admin_scheme, array('sunrise', 'ectoplasm', 'midnight', 'ocean', 'coffee', 'blue', 'modern', 'light'))) { ?>
    #header-admin .header-wrapper > div a:hover, #header-admin .header-wrapper > div a.active {color:#fff;}
    #header-admin .header-wrapper > div a:hover, #header-admin .header-wrapper > div a.active, #header-admin #osc_toolbar_logout a:hover {color:#fff;background:rgba(0,0,0,0.2);}
    #header-admin a .circle {background: rgba(0,0,0,0.2);}
    @media screen and (max-width: 767px) { #header-admin .header-wrapper > div a {color:#eee;} }
    <?php } ?>
    
    <?php if($admin_scheme == 'sunrise') { ?>
    #header-admin {background: #b32924;}
    @media screen and (max-width: 767px) { 
      #header-admin .osc_mobile_list, #header-admin .header-wrapper > div a:hover, #header-admin .header-wrapper > div a.active {background:#cf4944;}
      #header-admin #osc_toolbar_mobilemenu a:after {background:#dd823b;}  
    }
    <?php } else if ($admin_scheme == 'ectoplasm') { ?>
    #header-admin {background: #413256;}
    #header-admin a .circle { background: #d46f15; }
    @media screen and (max-width: 767px) { 
      #header-admin .osc_mobile_list, #header-admin .header-wrapper > div a:hover, #header-admin .header-wrapper > div a.active {background:#523f6d;}
      #header-admin #osc_toolbar_mobilemenu a:after {background:#d46f15;}  
    }
    <?php } else if ($admin_scheme == 'midnight') { ?>
    #header-admin {background: #25282b;}
    #header-admin a .circle { background: #e14d43; }
    @media screen and (max-width: 767px) { 
      #header-admin .osc_mobile_list, #header-admin .header-wrapper > div a:hover, #header-admin .header-wrapper > div a.active {background:#363b3f;}
      #header-admin #osc_toolbar_mobilemenu a:after {background:#e14d43;}
    }
    <?php } else if ($admin_scheme == 'ocean') { ?>
    #header-admin {background: #627c83;}
    #header-admin a .circle { background: #9ebaa0; }
    @media screen and (max-width: 767px) { 
      #header-admin .osc_mobile_list, #header-admin .header-wrapper > div a:hover, #header-admin .header-wrapper > div a.active {background:#738e96;}
      #header-admin #osc_toolbar_mobilemenu a:after {background:#aa9d88;}
    }
    <?php } else if ($admin_scheme == 'coffee') { ?>
    #header-admin {background: #46403c;}
    #header-admin a .circle { background: #9ea476; }
    @media screen and (max-width: 767px) { 
      #header-admin .osc_mobile_list, #header-admin .header-wrapper > div a:hover, #header-admin .header-wrapper > div a.active {background:#59524c;color:#fff;}
      #header-admin #osc_toolbar_mobilemenu a:after {background:#9ea476;}
    }
    <?php } else if ($admin_scheme == 'blue') { ?>
    #header-admin {background: #096484;}
    #header-admin a .circle { background: #e1a948; }
    @media screen and (max-width: 767px) { 
      #header-admin .osc_mobile_list, #header-admin .header-wrapper > div a:hover, #header-admin .header-wrapper > div a.active {background:#4796b3;color:#fff;}
      #header-admin #osc_toolbar_mobilemenu a:after {background:#e1a948;}
    }
    <?php } else if ($admin_scheme == 'modern') { ?>
    #header-admin {background: #1e1e1e;}
    #header-admin a .circle { background: #3858e9; }
    @media screen and (max-width: 767px) { 
      #header-admin .osc_mobile_list, #header-admin .header-wrapper > div a:hover, #header-admin .header-wrapper > div a.active {background:#000;color:#fff;}
      #header-admin #osc_toolbar_mobilemenu a:after {background:#33f078;}
    }
    <?php } else if ($admin_scheme == 'light') { ?>
    #header-admin {background: #e5e5e5;}
    #header-admin a .circle { background: #d64e07; }
    body #header-admin #osc_toolbar_back i.fa {color:#999;}
    body #header-admin .header-wrapper > div a {color:#666;}
    @media screen and (max-width: 767px) { 
      #header-admin .osc_mobile_list, #header-admin .header-wrapper > div a:hover, #header-admin .header-wrapper > div a.active {background:#fff;color:#666;}
      body #header-admin a {color:#666;}
      body #header-admin .header-wrapper > div a {color:#999;}
      #header-admin #osc_toolbar_mobilemenu a:after {background:#d64e07;}
    }
    <?php } ?>    

  </style>
  <?php
  }
}


function osc_admin_toolbar_in_front_js() {
  if(osc_is_admin_user_logged_in() && osc_admin_toolbar_front_enabled()) {
  ?>
  <script>
  $(document).ready(function() {
    $('body').on('click', '#osc_toolbar_mobilemenu', function(e) {
      e.preventDefault();
      $('#header-admin .osc_mobile_list').slideToggle(200);
    });
    
    $(document).click(function(event) { 
      var $target = $(event.target);
      if(!$target.closest('#header-admin #osc_toolbar_mobilemenu').length && !$target.closest('#header-admin .osc_mobile_list').length && $('#header-admin .osc_mobile_list').is(":visible")) {
        $('#header-admin .osc_mobile_list').slideUp(200);
      }        
    });
  });
  </script>
  <?php
  }
}

osc_add_hook('footer', 'osc_admin_toolbar_in_front_js');


/**
 * clean optimization files from folder oc-includes/uploads/minify
 */
function osc_clean_optimization_files()
{
  foreach(glob(osc_base_path() . 'oc-content/uploads/minify/*.css') as $file) {
    unlink($file);
  }
  foreach(glob(osc_base_path() . 'oc-content/uploads/minify/*.js') as $file) {
    unlink($file);
  }
}

osc_add_hook('cron_weekly', 'osc_clean_optimization_files');


/**
 * return true if string contains any of array elements. Is case insensitive
 */
function osc_string_contains_array($string, $array) {
  if(is_array($array) && !empty($array) && count($array) > 0) {
    foreach ($array as $substr) {
      if (stripos($string, $substr) !== false) { 
        return true;
      }
    }
  }

  return false;
}


/**
 * calculate size of folder in megabytes
 */
function osc_dir_size($path, $measurement = true){
  $bytestotal = 0;
  $path = realpath($path);
  
  if($path!==false && $path!='' && file_exists($path)){
    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
      if($object->isReadable()) {
        $bytestotal += $object->getSize();
      }
    }
  }
  
  $size = round($bytestotal/1000000, 2);   // megabytes
  
  if($measurement) {
    return $size . 'Mb';
  }
  
  return $size;
}


/**
 * list all folders those are not readable or writtable
 */
function osc_dir_chmod($path){
  $path = realpath($path);

  //$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
  $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

  foreach($iterator as $file) {
    if($file->isDir()) {
      $filename = $file->getRealpath();
      $filename = str_replace(osc_base_path(), '', $filename);
      
      $not_writtable = array();
      $not_readable = array();
      if(!$file->isWritable() || !$file->isExecutable()) {
        $not_writtable[] = $filename;
      } else if(!$file->isReadable()) {
        $not_readable[] = $filename;
      }
    }
  }
  
  return array(
    'not_readable' => $not_readable,
    'not_writtable' => $not_writtable
  );
}


/**
 * convert base64 string into image
 */
function osc_base64_to_image($data) {
  $image_array_1 = explode(";", $data);
  $image_array_2 = explode(",", $image_array_1[1]);
  $data = base64_decode($image_array_2[1]);
    
  $image_name = osc_logged_user_id() . '_' . osc_generate_rand_string(5) . '_' . date('Ymd') . '.png'; 
  $image_url = osc_base_url() . 'oc-content/uploads/user-images/' . $image_name;
  $image_path = osc_content_path() . 'uploads/user-images/' . $image_name;

  file_put_contents($image_path, $data);
  User::newInstance()->updateProfileImg(osc_logged_user_id(), $image_name);

  return $image_url;
}


/**
 * generate random integer
 */
if(!function_exists('osc_generate_rand_int')) {
  function osc_generate_rand_int($length = 18) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
  }
}


/**
 * generate random string
 */
if(!function_exists('osc_generate_rand_string')) {
  function osc_generate_rand_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
  }
}


// GET SQL RESULT SET (array) 
function osc_get_query_results($sql) {
  if(trim($sql) == '') {
    return array(); 
  }

  $result = Item::newInstance()->dao->query($sql);
  if(!$result) { 
    return array();
  } else {
    $prepare = $result->result();
    return $prepare;
  }
}

// EXECUTE QUERY
function osc_execute_query($sql) {
  if(trim($sql) == '') {
    return false; 
  }

  $result = Item::newInstance()->dao->query($sql);
  return $result;  // true or false
}

// RETURN COUNT OF QUERY
function osc_get_count_query_data($sql) {
  if(trim($sql) == '') {
    return 0; 
  }

  $result = Item::newInstance()->dao->query($sql);
  if(!$result) { 
    return 0; 
  } else {
    $prepare = $result->row();
    return (reset($prepare) > 0 ? reset($prepare) : 0);   // first array element
  }
}

// SMART DATE
function osc_smart_date_diff( $time ) {
  $time_diff = round(abs(time() - strtotime( $time )) / 60);
  $time_diff_h = floor($time_diff/60);
  $time_diff_d = floor($time_diff/1440);
  $time_diff_w = floor($time_diff/10080);
  $time_diff_m = floor($time_diff/43200);
  $time_diff_y = floor($time_diff/518400);


  if($time_diff < 2) {
  $time_diff_name = __('minute ago');
  } else if ($time_diff < 60) {
  $time_diff_name = sprintf(__('%d minutes ago'), $time_diff);
  } else if ($time_diff < 120) {
  $time_diff_name = sprintf(__('%d hour ago'), $time_diff_h);
  } else if ($time_diff < 1440) {
  $time_diff_name = sprintf(__('%d hours ago'), $time_diff_h);
  } else if ($time_diff < 2880) {
  $time_diff_name = sprintf(__('%d day ago'), $time_diff_d);
  } else if ($time_diff < 10080) {
  $time_diff_name = sprintf(__('%d days ago'), $time_diff_d);
  } else if ($time_diff < 20160) {
  $time_diff_name = sprintf(__('%d week ago'), $time_diff_w);
  } else if ($time_diff < 43200) {
  $time_diff_name = sprintf(__('%d weeks ago'), $time_diff_w);
  } else if ($time_diff < 86400) {
  $time_diff_name = sprintf(__('%d month ago'), $time_diff_m);
  } else if ($time_diff < 518400) {
  $time_diff_name = sprintf(__('%d months ago'), $time_diff_m);
  } else if ($time_diff < 1036800) {
  $time_diff_name = sprintf(__('%d year ago'), $time_diff_y);
  } else {
  $time_diff_name = sprintf(__('%d years ago'), $time_diff_y);
  }

  return $time_diff_name;
}

function osc_is_backoffice() {
  if(defined('OC_ADMIN')) {
    if(OC_ADMIN === true) {
      return true;
    }
  }
  return false;
}

function osc_is_frontoffice() {
  return !osc_is_backoffice();
}

function osc_location_native_name_selector($object, $column = 's_name') {
  if(osc_get_current_user_locations_native() == 1) {
     if(isset($object[$column . '_native']) && @$object[$column . '_native'] <> '') {
       return $object[$column . '_native'];
     }
  }

  return (isset($object[$column]) ? $object[$column] : '');
}

function osc_phone_currency_autoload() {
  if(osc_is_publish_page() || osc_is_edit_page()) {
    ItemForm::phone_currency_autoload();
  }
}

osc_add_hook('footer', 'osc_phone_currency_autoload');

/**
 * @param null $catId
 */
function osc_meta_publish( $catId = null ) {
  osc_enqueue_script( 'php-date' );
  echo '<div class="row">';
  FieldForm::meta_fields_input( $catId );
  echo '</div>';
}


/**
 * @param null $catId
 * @param null $item_id
 */
function osc_meta_edit( $catId = null , $item_id = null ) {
  osc_enqueue_script( 'php-date' );
  echo '<div class="row">';
  FieldForm::meta_fields_input( $catId , $item_id );
  echo '</div>';
}


osc_add_hook( 'item_form' , 'osc_meta_publish' );
osc_add_hook( 'item_edit' , 'osc_meta_edit' );


function osc_tinymce_item_head() {
  if(osc_tinymce_items_enabled() == '1' && (osc_is_publish_page() || osc_is_edit_page())) {
    osc_enqueue_script('tiny_mce', array('jquery'));
  }
}

osc_add_hook('init' , 'osc_tinymce_item_head');


function osc_tinymce_item_script() {
  if(osc_tinymce_items_enabled() == '1' && (osc_is_publish_page() || osc_is_edit_page())) { ?>
  <script type="text/javascript">
    tinyMCE.init({
      selector: 'textarea[name^="description["]',
      width: "100%",
      height: "400px",
      language: 'en',
      theme_advanced_toolbar_align : "left",
      theme_advanced_toolbar_location : "top",
      plugins : [
        "advlist autolink lists link image charmap preview anchor",
        "searchreplace visualblocks fullscreen",
        "insertdatetime media table paste autoresize"
      ],
      min_height: 350,
      max_height: 600,
      entity_encoding : "raw",
      theme_advanced_buttons1_add : "forecolorpicker,fontsizeselect",
      theme_advanced_buttons2_add: "media",
      theme_advanced_buttons3: "",
      theme_advanced_disable : "styleselect,anchor",
      relative_urls : false,
      remove_script_host : false,
      convert_urls : false,
      setup : function(editor) {
        editor.on("change keyup", function(e){
          //tinyMCE.triggerSave(); // updates all instances
          editor.save();
          $(editor.getElement()).trigger('change');
        });
      }
    });
  </script>
  <?php
  }
}

osc_add_hook('footer', 'osc_tinymce_item_script', 10);


function osc_tinymce_user_head() {
  if(osc_tinymce_users_enabled() == '1' && osc_is_user_profile()) {
    osc_enqueue_script('tiny_mce', array('jquery'));
  }
}

osc_add_hook('init' , 'osc_tinymce_user_head');


function osc_tinymce_user_script() {
  if(osc_tinymce_users_enabled() == '1' && osc_is_user_profile()) { ?>
  <script type="text/javascript">
    tinyMCE.init({
      selector: "textarea[name^='s_info[']",
      mode : "textareas",
      width: "100%",
      height: "560px",
      language: 'en',
      content_style: "body {font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;}",
      theme_advanced_toolbar_align : "left",
      theme_advanced_toolbar_location : "top",
      plugins : [
        "advlist autolink lists link image charmap preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table paste"
      ],
      entity_encoding : "raw",
      theme_advanced_buttons1_add : "forecolorpicker,fontsizeselect",
      theme_advanced_buttons2_add: "media",
      theme_advanced_buttons3: "",
      theme_advanced_disable : "styleselect,anchor",
      relative_urls : false,
      remove_script_host : false,
      convert_urls : false
    });
  </script>
  <?php
  }
}

osc_add_hook('footer', 'osc_tinymce_user_script', 10);



function osc_rotate_js() {
  if(osc_is_publish_page() || osc_is_edit_page()) {
  osc_enqueue_script('jquery-rotate', array('jquery'));
  }
}

osc_add_hook('init' , 'osc_rotate_js');

/**
 *
 * All CF will be searchable
 *
 * @param null $catId
 */
function osc_meta_search( $catId = null ) {
  FieldForm::meta_fields_search( $catId );
}


osc_add_hook( 'search_form' , 'osc_meta_search' );

/**
 * @return string
 * @throws \Exception
 */
function search_title() {
  $region   = osc_search_region();
  $city   = osc_search_city();
  $category = osc_search_category_id();
  $result   = '';

  $b_show_all = ( $region == '' && $city == '' && $category == '' );
  $b_category = ( $category != '' );
  $b_city   = ( $city != '' );
  $b_region   = ( $region != '' );

  if ( $b_show_all ) {
    return __( 'Search results' );
  }

  if ( osc_get_preference( 'seo_title_keyword' ) != '' ) {
    $result .= osc_get_preference( 'seo_title_keyword' ) . ' ';
  }

  if ( $b_category && ! empty( $category ) ) {
    $cat = Category::newInstance()->findByPrimaryKey( $category[ 0 ] );
    if ( isset( $cat[ 's_name' ] ) ) {
      $result .= $cat[ 's_name' ] . ' ';
    }
  }

  if ( $b_city ) {
    $result .= $city;
  } else if ( $b_region ) {
    $result .= $region;
  }

  return $result;
}


/**
 * @return bool|mixed
 * @throws \Exception
 */
function meta_title() {
  $location = Rewrite::newInstance()->get_location();
  $section  = Rewrite::newInstance()->get_section();
  $text   = '';

  switch ( $location ) {
    case ( 'item' ):
      switch ( $section ) {
        case 'item_add':
          $text = __( 'Publish a listing' );
          break;
        case 'item_edit':
          $text = __( 'Edit your listing' );
          break;
        case 'send_friend':
          $text = __( 'Send to a friend' ) . ' - ' . osc_item_title();
          break;
        case 'contact':
          $text = __( 'Contact seller' ) . ' - ' . osc_item_title();
          break;
        default:
          $text = osc_item_title() . ' ' . osc_item_city();
          break;
      }
      break;
    case( 'page' ):
      $text = osc_static_page_title();
      break;
    case( 'error' ):
      $text = __( 'Error' );
      break;
    case( 'search' ):
      $region   = osc_search_region();
      $city   = osc_search_city();
      $pattern  = osc_search_pattern();
      $category = osc_search_category_id();
      $s_page   = '';
      $i_page   = Params::getParam( 'iPage' );

      if ( $i_page != '' && $i_page > 1 ) {
        $s_page = ' - ' . __( 'page' ) . ' ' . $i_page;
      }

      $b_show_all = ( $region == '' && $city == '' && $pattern == '' && empty( $category ) );
      $b_category = ! empty( $category );
      $b_pattern  = ( $pattern != '' );
      $b_city   = ( $city != '' );
      $b_region   = ( $region != '' );

      if ( $b_show_all ) {
        $text = __( 'Show all listings' ) . ' - ' . $s_page . osc_page_title();
      }

      $result = '';
      if ( $b_pattern ) {
        $result .= $pattern . ' &raquo; ';
      }

      if ( $b_category && is_array( $category ) && count( $category ) > 0 ) {
        $cat = Category::newInstance()->findByPrimaryKey( $category[ 0 ] );
        if ( $cat ) {
          $result .= $cat[ 's_name' ] . ' ';
        }
      }

      if ( $b_city ) {
        $result .= $city . ' &raquo; ';
      } else if ( $b_region ) {
        $result .= $region . ' &raquo; ';
      }

      $result = preg_replace( '|\s?&raquo;\s$|' , '' , $result );

      if ( $result == '' ) {
        $result = __( 'Search results' );
      }

      $text = '';
      if ( osc_get_preference( 'seo_title_keyword' ) != '' ) {
        $text .= osc_get_preference( 'seo_title_keyword' ) . ' ';
      }
      $text .= $result . $s_page;
      break;
    case( 'login' ):
      switch ( $section ) {
        case( 'recover' ):
          $text = __( 'Recover your password' );
          break;
        case( 'forgot' ):
          $text = __( 'Recover my password' );
          break;
        default:
          $text = __( 'Login' );
      }
      break;
    case( 'register' ):
      $text = __( 'Create a new account' );
      break;

    case( 'user' ):
      switch ( $section ) {
        case( 'dashboard' ):
          $text = __( 'Dashboard' );
          break;
        case( 'items' ):
          $text = __( 'Manage my listings' );
          break;
        case( 'alerts' ):
          $text = __( 'Manage my alerts' );
          break;
        case( 'profile' ):
          $text = __( 'Update my profile' );
          break;
        case( 'pub_profile' ):
          $text = __( 'Public profile' ) . ' - ' . osc_user_name();
          break;
        case( 'change_email' ):
          $text = __( 'Change my email' );
          break;
        case( 'change_username' ):
          $text = __( 'Change my username' );
          break;
        case( 'change_password' ):
          $text = __( 'Change my password' );
          break;
      }
      break;
    case( 'contact' ):
      $text = __( 'Contact' );
      break;
    case( 'custom' ):
      $text = Rewrite::newInstance()->get_title();
      break;
    default:
      $text = osc_page_title();
      break;
  }

  if ( ! osc_is_home_page() ) {
    if ( $text != '' ) {
      $text .= ' - ' . osc_page_title();
    } else {
      $text = osc_page_title();
    }
  }

  return osc_apply_filter( 'meta_title_filter' , $text );
}


/**
 * @return bool|mixed
 * @throws \Exception
 */
function meta_description() {
  $text = '';
  // home page
  if ( osc_is_home_page() ) {
    $text = osc_page_description();
  }
  // static page
  if ( osc_is_static_page() ) {
    $text = osc_highlight( osc_static_page_text() , 140 , '' , '' );
  }
  // search
  if ( osc_is_search_page() ) {
    if ( osc_has_items() ) {
      $text = osc_item_category() . ' ' . osc_item_city() . ', ' . osc_highlight( osc_item_description() , 120 );
    }
    osc_reset_items();
  }
  // listing
  if ( osc_is_ad_page() ) {
    $text = osc_item_category() . ' ' . osc_item_city() . ', ' . osc_highlight( osc_item_description() , 120 );
  }

  return osc_apply_filter( 'meta_description_filter' , $text );
}


/**
 * @return bool|mixed
 * @throws \Exception
 */
function meta_keywords() {
  $text = '';
  // search
  if ( osc_is_search_page() ) {
    if ( osc_has_items() ) {
      $keywords   = array ();
      $keywords[] = osc_item_category();
      if ( osc_item_city() != '' ) {
        $keywords[] = osc_item_city();
        $keywords[] = sprintf( '%s %s' , osc_item_category() , osc_item_city() );
      }
      if ( osc_item_region() != '' ) {
        $keywords[] = osc_item_region();
        $keywords[] = sprintf( '%s %s' , osc_item_category() , osc_item_region() );
      }
      if ( ( osc_item_city() != '' ) && ( osc_item_region() != '' ) ) {
        $keywords[] = sprintf( '%s %s %s' , osc_item_category() , osc_item_region() , osc_item_city() );
        $keywords[] = sprintf( '%s %s' , osc_item_region() , osc_item_city() );
      }
      $text = implode( ', ' , $keywords );
    }
    osc_reset_items();
  }
  // listing
  if ( osc_is_ad_page() ) {
    $keywords   = array ();
    $keywords[] = osc_item_category();
    if ( osc_item_city() != '' ) {
      $keywords[] = osc_item_city();
      $keywords[] = sprintf( '%s %s' , osc_item_category() , osc_item_city() );
    }
    if ( osc_item_region() != '' ) {
      $keywords[] = osc_item_region();
      $keywords[] = sprintf( '%s %s' , osc_item_category() , osc_item_region() );
    }
    if ( ( osc_item_city() != '' ) && ( osc_item_region() != '' ) ) {
      $keywords[] = sprintf( '%s %s %s' , osc_item_category() , osc_item_region() , osc_item_city() );
      $keywords[] = sprintf( '%s %s' , osc_item_region() , osc_item_city() );
    }
    $text = implode( ', ' , $keywords );
  }

  return osc_apply_filter( 'meta_keywords_filter' , $text );
}


/**
 * @return array
 * @throws \Exception
 */
function osc_search_footer_links() {
  if ( ! osc_rewrite_enabled() ) {
    return array ();
  }

  $categoryID = osc_search_category_id();
  if ( ! empty( $categoryID ) && Category::newInstance()->isRoot( current( $categoryID ) ) ) {
    $cat = Category::newInstance()->findSubcategories( current( $categoryID ) );
    if ( count( $cat ) > 0 ) {
      $categoryID = array ();
      foreach ( $cat as $c ) {
        $categoryID[] = $c[ 'pk_i_id' ];
      }
    }
  }

  if ( osc_search_city() != '' ) {
    return array ();
  }

  $regionID = '';
  if ( osc_search_region() != '' ) {
    $aRegion = Region::newInstance()->findByName( osc_search_region() );
    if ( isset( $aRegion[ 'pk_i_id' ] ) ) {
      $regionID = $aRegion[ 'pk_i_id' ];
    }
  }

  $conn = DBConnectionClass::newInstance();
  $data = $conn->getOsclassDb();
  $comm = new DBCommandClass( $data );

  $comm->select( 'i.fk_i_category_id' );
  $comm->select( 'l.*' );
  $comm->select( 'COUNT(*) AS total' );
  $comm->from( DB_TABLE_PREFIX . 't_item as i' );
  $comm->from( DB_TABLE_PREFIX . 't_item_location as l' );
  if ( ! empty( $categoryID ) ) {
    $comm->whereIn( 'i.fk_i_category_id' , $categoryID );
  }
  $comm->where( 'i.pk_i_id = l.fk_i_item_id' );
  $comm->where( 'i.b_enabled = 1' );
  $comm->where( 'i.b_active = 1' );
  $comm->where( sprintf( "dt_expiration >= '%s'" , date( 'Y-m-d H:i:s' ) ) );

  $comm->where( 'l.fk_i_region_id IS NOT NULL' );
  $comm->where( 'l.fk_i_city_id IS NOT NULL' );
  if ( $regionID > 0 ) {
    $comm->where( 'l.fk_i_region_id' , $regionID );
    $comm->groupBy( 'l.fk_i_city_id' );
  } else {
    $comm->groupBy( 'l.fk_i_region_id' );
  }
  $rs = $comm->get();

  if ( ! $rs ) {
    return array ();
  }

  return $rs->result();
}


/**
 * @param null $f
 *
 * @return string
 * @throws \Exception
 */
function osc_footer_link_url( $f = null ) {
  if ( $f == null ) {
    if ( View::newInstance()->_exists( 'footer_link' ) ) {
      $f = View::newInstance()->_get( 'footer_link' );
    } else {
      return '';
    }
  } else {
    View::newInstance()->_exportVariableToView( 'footer_link' , $f );
  }
  $params = array ();
  $tmp  = osc_search_category_id();
  if ( isset( $tmp ) ) {
    $params[ 'sCategory' ] = $f[ 'fk_i_category_id' ];
  }

  if ( osc_search_region() == '' ) {
    $params[ 'sRegion' ] = $f[ 'fk_i_region_id' ];
  } else {
    $params[ 'sCity' ] = $f[ 'fk_i_city_id' ];
  }

  return osc_search_url( $params );
}


/**
 * @param null $f
 *
 * @return string
 * @throws \Exception
 */
function osc_footer_link_title( $f = null ) {
  if ( $f == null ) {
    if ( View::newInstance()->_exists( 'footer_link' ) ) {
      $f = View::newInstance()->_get( 'footer_link' );
    } else {
      return '';
    }
  } else {
    View::newInstance()->_exportVariableToView( 'footer_link' , $f );
  }
  $text = '';

  if ( osc_get_preference( 'seo_title_keyword' ) != '' ) {
    $text .= osc_get_preference( 'seo_title_keyword' ) . ' ';
  }

  $cat = osc_get_category( 'id' , $f[ 'fk_i_category_id' ] );
  if ( @$cat[ 's_name' ] != '' ) {
    $text .= $cat[ 's_name' ] . ' ';
  }

  if ( osc_search_region() == '' ) {
    $text .= $f[ 's_region' ];
  } else {
    $text .= $f[ 's_city' ];
  }

  $text = trim( $text );

  return $text;
}


/**
 * Instantiate the admin toolbar object.
 *
 * @since  3.0
 * @access private
 * @return bool
 */
function _osc_admin_toolbar_init($is_front = false) {
  $adminToolbar = AdminToolbar::newInstance();

  $adminToolbar->init();
  $adminToolbar->add_menus($is_front);

  return true;
}


// and we hook our function via
osc_add_hook( 'init_admin' , '_osc_admin_toolbar_init' );

/**
 * Draws admin toolbar
 */
function osc_draw_admin_toolbar() {
  $adminToolbar = AdminToolbar::newInstance();

  // run hook for adding
  osc_run_hook( 'add_admin_toolbar_menus' );
  $adminToolbar->render();
}


/**
 * Add webtitle with link to frontend
 */
function osc_admin_toolbar_menu() {
  AdminToolbar::newInstance()->add_menu(array(
    'id'   => 'home' ,
    'title'  => '<span class="">' . osc_page_title() . '</span>' ,
    'href'   => osc_base_url() ,
    'meta'   => array ( 'class' => 'user-profile' ) ,
    'target' => ''
  ));
}


/**
 * Add logout link
 */
function osc_admin_toolbar_logout() {
  AdminToolbar::newInstance()->add_menu(array(
    'id'  => 'logout' ,
    'title' => __( 'Logout' ) ,
    'href'  => osc_admin_base_url( true ) . '?action=logout' ,
    'meta'  => array ( 'class' => 'btn btn-dim ico ico-32 ico-power float-right' )
  ));
}


/**
 * Add who is logged in
 */
function osc_admin_toolbar_logged_user() {
  if(osc_is_web_user_logged_in()) {
    AdminToolbar::newInstance()->add_menu(array(
      'id'  => 'logged',
      'title' => '<i class="fa fa-user"></i> <span>' . sprintf(__('Logged as %s'), osc_logged_user_name()) . '</span>',
      'href'  => osc_admin_base_url(true) . '?page=users&action=edit&id=' . osc_logged_user_id(),
      'meta'  => array ('class' => '')
    ));
  }
}


/**
 * Add edit link when on item page
 */
function osc_admin_toolbar_edit_item() {
  if(osc_is_ad_page() && osc_item_id() > 0) {
    AdminToolbar::newInstance()->add_menu(array(
      'id'  => 'edititem',
      'title' => '<i class="fa fa-edit"></i> <span>' . __('Edit item') . '</span>',
      'href'  => osc_admin_base_url(true) . '?page=items&action=item_edit&id=' . osc_item_id(),
      'meta'  => array ('class' => '')
    ));
  }
}


/**
 * Add edit link when on static page
 */
function osc_admin_toolbar_edit_page() {
  if(osc_is_static_page() && osc_static_page_id() > 0) {
    AdminToolbar::newInstance()->add_menu(array(
      'id'  => 'editpage',
      'title' => '<i class="fa fa-edit"></i> <span>' . __('Edit page') . '</span>',
      'href'  => osc_admin_base_url(true) . '?page=pages&action=edit&id=' . osc_static_page_id(),
      'meta'  => array ('class' => '')
    ));
  }
}

/**
 * Add edit link when on public profile page
 */
function osc_admin_toolbar_edit_user() {
  if(osc_is_public_profile() && osc_user_id() > 0) {
    AdminToolbar::newInstance()->add_menu(array(
      'id'  => 'edituser',
      'title' => '<i class="fa fa-edit"></i> <span>' . __('Edit user') . '</span>',
      'href'  => osc_admin_base_url(true) . '?page=users&action=edit&id=' . osc_user_id(),
      'meta'  => array ('class' => '')
    ));
  }
}


/**
 * Add logout link
 */
function osc_admin_toolbar_logout2() {
  AdminToolbar::newInstance()->add_menu(array(
    'id'  => 'logout' ,
    'title' => '<i class="fa fa-sign-out"></i> <span>' . __('Logout admin') . '</span>',
    'href'  => osc_admin_base_url( true ) . '?action=logout' ,
    'meta'  => array ( 'class' => '' )
  ));
}


/**
 * Add backoffice link to menu
 */
function osc_admin_toolbar_back() {
  AdminToolbar::newInstance()->add_menu(array(
    'id'   => 'back' ,
    'title'  => '<i class="fa fa-tachometer fa-tachometer-alt"></i> <span>' . __('Backoffice') . '</span>',
    'href'   => osc_admin_base_url() ,
    'meta'   => array ( 'class' => '' ) ,
    'target' => ''
  ));
}

function osc_admin_toolbar_comments() {
  $total = ItemComment::newInstance()->countAll( '( c.b_active = 0 OR c.b_enabled = 0 OR c.b_spam = 1 )' );
  if ( $total > 0 ) {
    $title = '<i class="circle circle-green">' . $total . '</i>' . __( 'New comments' );

    AdminToolbar::newInstance()->add_menu(
      array (
        'id'  => 'comments' ,
        'title' => $title ,
        'href'  => osc_admin_base_url( true ) . '?page=comments' ,
        'meta'  => array ( 'class' => 'action-btn action-btn-black' )
      )
    );
  }
}


function osc_admin_toolbar_spam() {
  $total = Item::newInstance()->countByMarkas( 'spam' );
  if ( $total > 0 ) {
    $title = '<i class="circle circle-red">' . $total . '</i>' . __( 'Spam' );

    AdminToolbar::newInstance()->add_menu(
      array (
        'id'  => 'spam' ,
        'title' => $title ,
        'href'  => osc_admin_base_url( true ) . '?page=items&action=items_reported&sort=spam' ,
        'meta'  => array ( 'class' => 'action-btn action-btn-black' )
      )
    );
  }
}


function osc_admin_toolbar_demo() {
  if(strpos(osc_logged_admin_username(), 'demo') === false) {   
    if(defined('DEMO_THEMES') && DEMO_THEMES === true) {
      $title = __('Themes Demo');
    } else if(defined('DEMO_PLUGINS') && DEMO_PLUGINS === true) {
      $title = __('Plugins Demo');
    } else if(defined('DEMO') && DEMO === true) {
      $title = __('Demo');
    } else {
      return false;
    }

    AdminToolbar::newInstance()->add_menu(
      array (
        'id'  => 'demo',
        'title' => $title,
        'href'  => '#',
        'meta'  => array( 'class' => 'action-btn action-btn-black' )
      )
    );
  }
}


/**
 * @param bool $force
 */
function osc_admin_toolbar_update_core( $force = false ) {
  if ( ! osc_is_moderator() ) {
    $data = json_decode( osc_update_core_json() , true );

    if ( $force ) {
      AdminToolbar::newInstance()->remove_menu( 'update_core' );
    }
    if ( isset( $data[ 'version' ] ) && $data[ 'version' ] > 0 ) {
      $title = sprintf( __( 'Osclass %s is available' ) , $data[ 's_name' ] );
      AdminToolbar::newInstance()->add_menu(
        array (
          'id'  => 'update_core' ,
          'title' => $title ,
          'href'  => osc_admin_base_url( true ) . '?page=tools&action=upgrade' ,
          'meta'  => array ( 'class' => 'action-btn action-btn-black' )
        )
      );
    }
  }
}


/**
 * @param bool $force
 *
 * @return int|string
 */
function osc_check_plugins_update( $force = false ) {
  $total = getPreference( 'plugins_update_count' );
  if ( $force ) {
    return _osc_check_plugins_update();
  } else if ( ( time() - (int) osc_plugins_last_version_check() ) > ( 24 * 3600 ) ) {
    osc_add_hook( 'admin_footer' , 'check_plugins_admin_footer' );
  }

  return $total;
}


/**
 * @return int
 */
function _osc_check_plugins_update() {
  $total      = 0;
  $array      = array ();
  $array_downloaded = array ();
  $plugins      = Plugins::listAll();
  foreach ( $plugins as $plugin ) {
    $info = osc_plugin_get_info( $plugin );
    if ( osc_check_plugin_update( @$info[ 'product_key' ] , @$info[ 'version' ] ) ) {
      $array[] = @$info[ 'product_key' ];
      $total ++;
    }
    $array_downloaded[] = @$info[ 'product_key' ];
  }

  osc_set_preference( 'plugins_to_update' , json_encode(array_filter($array)));
  osc_set_preference( 'plugins_downloaded' , json_encode(array_filter($array_downloaded)));
  osc_set_preference( 'plugins_update_count' , $total );
  osc_set_preference( 'plugins_last_version_check' , time() );
  osc_reset_preferences();

  return $total;
}


/**
 * @param bool $force
 */
function osc_admin_toolbar_update_plugins( $force = false ) {
  if ( ! osc_is_moderator() ) {
    $total = osc_check_plugins_update( $force );

    if ( $force ) {
      AdminToolbar::newInstance()->remove_menu( 'update_plugin' );
    }
    if ( $total > 0 ) {
      $title = '<i class="circle circle-gray">' . $total . '</i>' . __( 'Plugin updates' );
      AdminToolbar::newInstance()->add_menu(
        array (
          'id'  => 'update_plugin' ,
          'title' => $title ,
          'href'  => osc_admin_base_url( true ) . '?page=plugins#update-plugins' ,
          'meta'  => array ( 'class' => 'action-btn action-btn-black' )
        )
      );
    }
  }
}


/**
 * @param bool $force
 *
 * @return int|string
 */
function osc_check_themes_update( $force = false ) {
  $total = getPreference( 'themes_update_count' );
  if ( $force ) {
    return _osc_check_themes_update();
  } else if ( ( time() - (int) osc_themes_last_version_check() ) > ( 24 * 3600 ) ) {
    osc_add_hook( 'admin_footer' , 'check_themes_admin_footer' );
  }

  return $total;
}


/**
 * @return int
 */
function _osc_check_themes_update() {
  $total      = 0;
  $array      = array ();
  $array_downloaded = array ();
  $themes       = WebThemes::newInstance()->getListThemes();
  foreach ( $themes as $theme ) {
    $info = WebThemes::newInstance()->loadThemeInfo( $theme );
    if ( osc_check_theme_update( @$info[ 'product_key' ], @$info[ 'version' ] ) ) {
      $array[] = $theme;
      $total ++;
    }
    $array_downloaded[] = @$info[ 'product_key' ];
  }
  osc_set_preference( 'themes_to_update' , json_encode(array_filter($array)));
  osc_set_preference( 'themes_downloaded' , json_encode(array_filter($array_downloaded)));
  osc_set_preference( 'themes_update_count' , $total );
  osc_set_preference( 'themes_last_version_check' , time() );
  osc_reset_preferences();

  return $total;
}


/**
 * @param bool $force
 */
function osc_admin_toolbar_update_themes( $force = false ) {
  if ( ! osc_is_moderator() ) {
    $total = osc_check_themes_update( $force );

    if ( $force ) {
      AdminToolbar::newInstance()->remove_menu( 'update_theme' );
    }
    if ( $total > 0 ) {
      $title = '<i class="circle circle-gray">' . $total . '</i>' . __( 'Theme updates' );
      AdminToolbar::newInstance()->add_menu(
        array (
          'id'  => 'update_theme' ,
          'title' => $title ,
          'href'  => osc_admin_base_url( true ) . '?page=appearance' ,
          'meta'  => array ( 'class' => 'action-btn action-btn-black' )
        )
      );
    }
  }
}


/**
 * @param bool $force
 *
 * @return int|string
 */
function osc_check_languages_update( $force = false ) {
  $total = getPreference( 'languages_update_count' );
  if ( $force ) {
    return _osc_check_languages_update();
  } else if ( ( time() - (int) osc_languages_last_version_check() ) > ( 24 * 3600 ) ) {
    osc_add_hook( 'admin_footer' , 'check_languages_admin_footer' );
  }

  return $total;
}


/**
 * @return int
 */
function _osc_check_languages_update() {
  $total      = 0;
  $array      = array ();
  $array_downloaded = array ();
  $languages    = OSCLocale::newInstance()->listAll();
  foreach ( $languages as $lang ) {
    if ( osc_check_language_update( $lang[ 'pk_c_code' ] , $lang[ 's_version' ] ) ) {
      $array[] = $lang[ 'pk_c_code' ];
      $total ++;
    }
    $array_downloaded[] = $lang[ 'pk_c_code' ];
  }
  osc_set_preference( 'languages_to_update' , json_encode( $array ) );
  osc_set_preference( 'languages_downloaded' , json_encode( $array_downloaded ) );
  osc_set_preference( 'languages_update_count' , $total );
  osc_set_preference( 'languages_last_version_check' , time() );
  osc_reset_preferences();

  return $total;
}


/**
 * @param bool $force
 */
function osc_admin_toolbar_update_languages( $force = false ) {
  if ( ! osc_is_moderator() ) {
    $total = osc_check_languages_update( $force );

    if ( $force ) {
      AdminToolbar::newInstance()->remove_menu( 'update_language' );
    }
    if ( $total > 0 ) {
      $title = '<i class="circle circle-gray">' . $total . '</i>' . __( 'Language updates' );
      AdminToolbar::newInstance()->add_menu(
        array (
          'id'  => 'update_language' ,
          'title' => $title ,
          'href'  => osc_admin_base_url( true ) . '?page=languages' ,
          'meta'  => array ( 'class' => 'action-btn action-btn-black' )
        )
      );
    }
  }
}


// CHECK ALL UPDATES VIA DAILY
function osc_check_all_updates_cron() {
  _osc_check_plugins_update();
  _osc_check_themes_update();
  _osc_check_languages_update();

  osc_set_preference('last_version_check', time());
  $data = osc_file_get_contents('https://osclass-classifieds.com/api/latest_version.php');
  $data  = json_decode($data, true);

  if(isset($data['version'])) {
    if($data['version'] > osc_version()) {
      osc_set_preference('update_core_json', json_encode($data));
    } else {
      osc_set_preference('update_core_json', '');
    }

    osc_set_preference( 'last_version_check', time() );
  } else { 
    // Latest version couldn't be checked (site down?)
    osc_set_preference( 'last_version_check', time()-82800 ); // 82800 = 23 hours, so repeat check in one hour
  }
}

// Disabled for now, impact on API server is not clear
// osc_add_hook( 'cron_daily' , 'osc_check_all_updates_cron' );
