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


osc_enqueue_script('jquery-validate');
if(osc_tinymce_users_enabled() == '1') {
  osc_enqueue_script('tiny_mce');
}

$user    = __get('user');
$countries = __get('countries');
$regions   = __get('regions');
$cities  = __get('cities');
$locales   = __get('locales');

function customFrmText(){
  $user    = __get('user');
  $return = array();

  if( isset($user['pk_i_id']) ) {
    $return['edit']     = true;
    $return['title']    = __('Edit user');
    $return['action_frm'] = 'edit_post';
    $return['btn_text']   = __('Update user');
    $return['alerts'] = Alerts::newInstance()->findByUser($user['pk_i_id'], true);
  } else {
    $return['edit']     = false;
    $return['title']    = __('Add new user');
    $return['action_frm'] = 'create_post';
    $return['btn_text']   = __('Add new user');
    $return['alerts'] = array();
  }
  return $return;
}
function customPageHeader(){ ?>
  <h1><?php _e('Users'); ?></h1>
<?php
}
osc_add_hook('admin_page_header','customPageHeader');

function customPageTitle($string) {
  $aux = customFrmText();
  return sprintf('%s - %s', $aux['title'], $string);
}
osc_add_filter('admin_title', 'customPageTitle');

//customize Head
function customHead() {
  $user = __get('user');

  if(isset($user['pk_i_id'])) {
    UserForm::js_validation_edit();
  } else {
    UserForm::js_validation();
  }?>
  <?php UserForm::location_javascript("admin"); ?>

  <?php
}
osc_add_hook('admin_header','customHead', 10);


function customHead2() {
  if(osc_tinymce_users_enabled() == '1') { ?>
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
        "insertdatetime media table paste autoresize"
      ],
      min_height: 460,
      max_height: 600,
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
osc_add_hook('admin_header','customHead2', 10);

$aux  = customFrmText();

osc_current_admin_theme_path('parts/header.php'); 
?>

<?php if($aux['edit'] && count($aux['alerts'])>0) { ?>
  <style>
    #more-tooltip{
      position:absolute;
      background:#f2f2f2;
      border:solid 2px #bababa;
      margin-left:5px;
      margin-top:0px;
      padding:7px;
      max-width: 400px;
      border-radius:5px;
      --moz-border-radius: 5px;
      ---webkit-border-radius: 5px;
      z-index: 100;
    }
  </style>
  <script type="text/javascript">
  function delete_alert(id) {
    $("#alert_id").attr('value', id);
    $("#dialog-alert-delete").dialog('open');
  };

  $(document).ready(function(){
    $("#dialog-alert-delete").dialog({
      autoOpen: false,
      modal: true
    });

    $(".more-tooltip").hover(function(e){
      $('#more-tooltip').html($(this).attr("categories")).css({
        top: this.offsetTop - $('#more-tooltip').height() - 15,
        left: this.offsetLeft
      }).show();
    },function(){
      $('#more-tooltip').hide();
    });
    $('#more-tooltip').hide();

  });
  </script>
<?php }; ?>

<script type="text/javascript">
  $(document).ready(function(){
    $('form#register').validate({
      rules: {
        s_username: {
          required: true
        }
      },
      messages: {
        s_username: {
          required: '<?php echo osc_esc_js(__("Username: this field is required", "modern")); ?>.'
        }
      },
      errorLabelContainer: "#error_list",
      wrapper: "li",
      invalidHandler: function(form, validator) {
        $('html,body').animate({ scrollTop: $('h1').offset().top }, { duration: 250, easing: 'swing'});
      },
      submitHandler: function(form){
        $('button[type=submit], input[type=submit]').attr('disabled', 'disabled');
        form.submit();
      }
    });

    var cInterval;
    $("#s_username").keydown(function(event) {
      if($("#s_username").attr("value")!='') {
        clearInterval(cInterval);
        cInterval = setInterval(function(){
          $.getJSON(
            "<?php echo osc_base_url(true); ?>?page=ajax&action=check_username_availability",
            {"s_username": $("#s_username").attr("value")},
            function(data){
              clearInterval(cInterval);
              if(data.exists==0) {
                $("#available").text('<?php echo osc_esc_js(__("The username is available", "modern")); ?>');
              } else {
                $("#available").text('<?php echo osc_esc_js(__("The username is NOT available", "modern")); ?>');
              }
            }
          );
        }, 1000);
      }
    });
  });
</script>

<div class="grid-row no-bottom-margin">
  <div class="row-wrapper">
    <h2 class="render-title">
      <?php echo $aux['title']; ?> 
      
      <?php if(isset($user['pk_i_id'])) { ?>
        #<?php echo $user['pk_i_id']; ?>
      <?php } ?>
    </h2>
  </div>
</div>

<div class="grid-row no-bottom-margin float-right">
  <div class="row-wrapper">
    <?php if( __get('user') != '') { 
      $actions = __get('actions'); ?>
    <ul id="item-action-list">
      <?php foreach($actions as $action) { ?>
      <li>
        <?php echo $action; ?>
      </li>
      <?php } ?>
    </ul>
    <div class="clear"></div>
    <?php } ?>
  </div>
</div>

<div class="clear"></div>

<!-- add user form -->
<div class="settings-user">
  <ul id="error_list"></ul>
  <form name="register" action="<?php echo osc_admin_base_url(true); ?>" method="post">
    <input type="hidden" name="page" value="users" />
    <input type="hidden" name="action" value="<?php echo $aux['action_frm']; ?>" />
    <h3 class="render-title"><?php _e('Contact info'); ?></h3>
    <?php UserForm::primary_input_hidden($user); ?>
    <?php if($aux['edit']) { ?>
      <input type="hidden" name="b_enabled" value="<?php echo $user['b_enabled']; ?>" />
      <input type="hidden" name="b_active" value="<?php echo $user['b_active']; ?>" />
    <?php } ?>
    <fieldset>
    <div class="form-horizontal">
      <?php if($aux['edit']) { ?>
      <div class="form-row">
        <div class="form-label"><?php _e('Last access'); ?></div>
        <div class="form-controls">
          <div class='form-label-checkbox'>
          <?php echo sprintf(__("%s on %s"), $user['s_access_ip'], $user['dt_access_date']);?>
          </div>
        </div>
      </div>
      <?php }; ?>

      <?php if($aux['edit']) { ?>
      <div class="form-row">
        <div class="form-label"><?php _e('Failed logins'); ?></div>
        <div class="form-controls">
          <div class='form-label-checkbox'>
          <?php if($user['i_login_fails'] > 0) { ?>
            <?php echo sprintf(__("%s failed attempts, last one on %s"), $user['i_login_fails'], $user['dt_login_fail_date']);?>
          <?php } else { ?>
            <?php _e('None'); ?>
          <?php } ?>
          </div>
        </div>
      </div>
      <?php }; ?>

      <?php if($aux['edit'] && osc_profile_img_users_enabled()) { ?>
        <div class="form-row">
          <div class="form-label"><?php _e('Profile picture'); ?></div>
          <div class="form-controls">
            <p class="user-img">
              <img src="<?php echo osc_user_profile_img_url($user['pk_i_id']); ?>" alt="<?php echo osc_esc_html($user['s_name']); ?>"/>
            </p>
            <?php if($user['s_profile_img'] <> '') { ?>
              <p> 
                <a href="<?php echo osc_admin_base_url(true); ?>?page=ajax&action=remove_profile_img&userId=<?php echo $user['pk_i_id']; ?>" class="btn remove-profile-img"><i class="fa fa-trash"></i> <?php _e('Remove'); ?></a>
              </p>
            <?php } ?>
          </div>
        </div>
      <?php }; ?>
      
      <?php if(isset($user['pk_i_id'])) { ?>
        <div class="form-row">
          <div class="form-label"><?php _e('ID'); ?></div>
          <div class="form-controls">
            <input disabled class="disabled input-small" type="text" value="<?php echo $user['pk_i_id']; ?>"/>
          </div>
        </div>
      <?php } ?>
      
      <div class="form-row">
        <div class="form-label"><?php _e('Name'); ?></div>
        <div class="form-controls">
          <?php UserForm::name_text($user); ?>
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-label"><?php _e('Username'); ?></div>
        <div class="form-controls">
          <?php UserForm::username_text($user); ?> <div id="available"></div>
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-label"><?php _e('E-mail'); ?> <em><?php _e('(required)'); ?></em></div>
        <div class="form-controls">
          <?php UserForm::email_text($user); ?>
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-label"><?php _e('Cell phone'); ?></div>
        <div class="form-controls">
          <?php UserForm::mobile_text($user); ?>
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-label"><?php _e('Phone'); ?></div>
        <div class="form-controls">
          <?php UserForm::phone_land_text($user); ?>
        </div>
      </div>
      <div class="form-row">
        <div class="form-label"><?php _e('Website'); ?></div>
        <div class="form-controls">
          <?php UserForm::website_text($user); ?>
        </div>
      </div>
      
      <h3 class="render-title"><?php _e('About you'); ?></h3>
      <div class="form-row">
        <div class="form-label"><?php _e('User type'); ?></div>
        <div class="form-controls">
          <?php UserForm::is_company_select($user); ?>
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-label"><?php _e('Additional information'); ?></div>
        <div class="form-controls additional-info">
          <?php UserForm::multilanguage_info($locales, $user); ?>
        </div>
      </div>
      
      <h3 class="render-title"><?php _e('Location'); ?></h3>
      <div class="form-row">
        <div class="form-label"><?php _e('Country'); ?></div>
        <div class="form-controls">
          <?php UserForm::country_select($countries, $user); ?>
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-label"><?php _e('Region'); ?></div>
        <div class="form-controls">
          <?php UserForm::region_select($regions, $user); ?>
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-label"><?php _e('City'); ?></div>
        <div class="form-controls">
          <?php UserForm::city_select($cities, $user); ?>
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-label"><?php _e('City area'); ?></div>
        <div class="form-controls">
          <?php UserForm::city_area_text($user); ?>
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-label"><?php _e('Zip code'); ?></div>
        <div class="form-controls">
          <?php UserForm::zip_text($user); ?>
        </div>
      </div>
      <div class="form-row">
        <div class="form-label"><?php _e('Address'); ?></div>
        <div class="form-controls">
          <?php UserForm::address_text($user); ?>
        </div>
      </div>
      
      <h3 class="render-title"><?php _e('Password'); ?></h3>
      <div class="form-row">
        <div class="form-label"><?php _e('New password'); ?><?php if(!$aux['edit']) { printf('<br/><em>%s</em>', __('(twice, required)')); } ?></div>
        <div class="form-controls">
          <?php UserForm::password_text($user); ?>
          <?php if($aux['edit']) { ?>
            <p class="help-inline"><?php _e("If you'd like to change the password, type a new one. Otherwise leave this blank"); ?></p>
          <?php } ?>
          <div class="input-separate-top newp">
            <?php UserForm::check_password_text($user); ?>
            <?php if($aux['edit']) { ?>
              <p class="help-inline"><?php _e('Type your new password again'); ?></p>
            <?php } ?>
          </div>
        </div>
      </div>

      <?php 
        if(!$aux['edit']) {
          osc_run_hook('user_register_form');
        } else {
          osc_run_hook('user_profile_form', $user);
          osc_run_hook('user_form', $user);
        }
      ?>

      <div class="clear"></div>
      
      <div class="form-actions">
        <input type="submit" value="<?php echo osc_esc_html($aux['btn_text']); ?>" class="btn btn-submit" />
      </div>
    </div>
    </fieldset>
  </form>
</div>


<?php if($aux['edit'] && count($aux['alerts'])>0) { ?>
  <div class="settings-user">
    <ul id="error_list"></ul>
    <form>
      <div class="form-horizontal">
        <h3 class="render-title"><?php _e('Alerts'); ?></h3>
        <div class="form-row">
          <?php for($k=0;$k<count($aux['alerts']);$k++) { 
            $array_conditions = (array)json_decode($aux['alerts'][$k]['s_search'], true);
            $raw_data = osc_get_raw_search($array_conditions);
            $new_search = new Search();
            $new_search->setJsonAlert($array_conditions);
            $new_search->limit(0, 2);
            $results = $new_search->doSearch();
            ?>
            <div class="form-label">
              <?php echo sprintf(__('Alert #%d'), ($k+1)); ?>
              <br/>
              <?php if(isset($raw_data['sPattern']) && $raw_data['sPattern']!='') {?>
                <?php echo sprintf(__("<b>Pattern:</b> %s"), $raw_data['sPattern']); ?><br/>
              <?php }; ?>

              <?php if(isset($raw_data['aCategories']) && !empty($raw_data['aCategories'])) {
                $l = min(count($raw_data['aCategories']), 2);
                $cat_array = array();
                for($c=0;$c<$l;$c++) {
                  $cat_array[] = $raw_data['aCategories'][$c];
                }
                if(count($raw_data['aCategories'])>$l) {
                  $cat_array[] = '<a href="#" class="more-tooltip" categories="'.osc_esc_html(implode(", ", $raw_data['aCategories'])).'" >'.__("...More").'</a>';
                }
                ?>
                <?php echo sprintf(__("<b>Categories:</b> %s"), implode(", ", $cat_array)); ?><br/>
              <?php }; ?>
              
              <a href="javascript:delete_alert('<?php echo $aux['alerts'][$k]['pk_i_id']; ?>');" ><?php _e("Delete"); ?></a>
              &nbsp;|&nbsp;
              <?php if($aux['alerts'][$k]['b_active']==1) { ?>
              <a href="<?php echo osc_admin_base_url(true)."?page=users&action=status_alerts&id[]=".$aux['alerts'][$k]['pk_i_id']."&status=0&user_id=".$user['pk_i_id']; ?>" ><?php _e("Disable"); ?></a>
              <?php } else { ?>
              <a href="<?php echo osc_admin_base_url(true)."?page=users&action=status_alerts&id[]=".$aux['alerts'][$k]['pk_i_id']."&status=1&user_id=".$user['pk_i_id']; ?>" ><?php _e("Enable"); ?></a>
              <?php }; ?>
            </div>
            <div class="form-controls">
              <?php if(!empty($results)) {
                foreach($results as $r) { ?>
                <label><b><?php echo $r['s_title']; ?></b></label>
                <p><?php echo $r['s_description']; ?></p>
                <?php };
              } else { ?>
                <label>&nbsp;</label>
                <p>&nbsp;</p>
              <?php }; ?>
            </div>
            <div class="clear"></div>
          <?php }; ?>
        </div>
        <div class="clear"></div>
      </div>
      </fieldset>
    </form>
  </div>

  <form id="dialog-alert-delete" method="get" action="<?php echo osc_admin_base_url(true); ?>" class="has-form-actions hide" title="<?php echo osc_esc_html(__('Delete alert')); ?>">
    <input type="hidden" name="page" value="users" />
    <input type="hidden" name="action" value="delete_alerts" />
    <input type="hidden" id="alert_id" name="alert_id[]" value="" />
    <input type="hidden" id="alert_user_id" name="alert_user_id" value="<?php echo $user['pk_i_id']; ?>" />
    <div class="form-horizontal">
      <div class="form-row">
        <?php _e('Are you sure you want to delete this alert?'); ?>
      </div>
      <div class="form-actions">
        <div class="wrapper">
        <a class="btn" href="javascript:void(0);" onclick="$('#dialog-alert-delete').dialog('close');"><?php _e('Cancel'); ?></a>
        <input id="alert-delete-submit" type="submit" value="<?php echo osc_esc_html( __('Delete') ); ?>" class="btn btn-red" />
        </div>
      </div>
    </div>
  </form>
  <div id="more-tooltip"></div>
<?php }; ?>
<!-- /add user form -->

<script>
$('a.btn.remove-profile-img').on('click', function(e){
  e.preventDefault();
  var elem = $(this);
  elem.find('i').removeClass().addClass('fa').addClass('fa-spinner').addClass('fa-spin');

  $.ajax({
    url: elem.attr('href'),
    type: "POST",
    dataType: "json",
    success: function(data) {
      if(data.error == 0) {
        elem.slideUp(200);
        $('.user-img img').attr('src', data.message);
      }
    }
  });

  return false;
});
</script>

<?php osc_current_admin_theme_path('parts/footer.php'); ?>