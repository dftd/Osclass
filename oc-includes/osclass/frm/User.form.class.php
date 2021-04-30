<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

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


class UserForm extends Form {
  static public function primary_input_hidden($user) {
    parent::generic_input_hidden("id", (isset($user["pk_i_id"]) ? $user['pk_i_id'] : '') );
  }

  static public function name_text($user = null) {
    if( Session::newInstance()->_getForm('user_s_name') != '' ) {
      $user['s_name'] = Session::newInstance()->_getForm('user_s_name');
    }
    parent::generic_input_text("s_name", isset($user['s_name'])? $user['s_name'] : '', null, false);
  }

  static public function username_text($user = null) {
    if( Session::newInstance()->_getForm('user_s_username') != '' ) {
      $user['s_username'] = Session::newInstance()->_getForm('user_s_username');
    }
    parent::generic_input_text("s_username", isset($user['s_username'])? $user['s_username'] : '', null, false);
  }

  static public function email_login_text($user = null) {
    parent::generic_input_text("email", isset($user['s_email'])? $user['s_email'] : osc_check_demo_login_data('email'), null, false);
  }

  static public function password_login_text($user = null) {
    parent::generic_password("password", osc_check_demo_login_data('password'), null, false);
  }

  static public function rememberme_login_checkbox($user = null) {
    parent::generic_input_checkbox("remember", '1', false);
  }

  static public function old_password_text($user = null) {
    parent::generic_password("old_password", '', null, false);
  }

  static public function password_text($user = null) {
    parent::generic_password("s_password", '', null, false);
  }

  static public function check_password_text($user = null) {
    parent::generic_password("s_password2", '', null, false);
  }

  static public function email_text($user = null) {
    if( Session::newInstance()->_getForm('user_s_email') != '' ) {
      $user['s_email'] = Session::newInstance()->_getForm('user_s_email');
    }
    parent::generic_input_text("s_email", isset($user['s_email'])? $user['s_email'] : '', null, false);
  }

  static public function website_text($user = null) {
    parent::generic_input_text("s_website", isset($user['s_website'])? $user['s_website'] : '', null, false);
  }

  static public function mobile_text($user = null) {
    if( Session::newInstance()->_getForm('user_s_phone_mobile') != '' ) {
      $user['s_phone_mobile'] = Session::newInstance()->_getForm('user_s_phone_mobile');
    }
    parent::generic_input_text("s_phone_mobile", isset($user['s_phone_mobile'])? $user['s_phone_mobile'] : '', null, false);
  }

  static public function phone_land_text($user = null) {
    if( Session::newInstance()->_getForm('user_s_phone_land') != '' ) {
      $user['s_phone_land'] = Session::newInstance()->_getForm('user_s_phone_land');
    }
    parent::generic_input_text("s_phone_land", isset($user['s_phone_land'])? $user['s_phone_land'] : '', null, false);
  }

  static public function info_textarea($name, $locale = 'en_US', $value = '') {
    parent::generic_textarea($name . '[' . $locale . ']', $value);
  }

  static public function multilanguage_info($locales, $user = null) {
    $num_locales = count($locales);
    if($num_locales > 1) { echo '<div class="tabber">'; }
    foreach($locales as $locale) {
      if($num_locales>1) { echo '<div class="tabbertab">'; };
        if($num_locales > 1) { echo '<h2>' . $locale['s_name'] . '</h2>'; }
        $info = '';
        if( is_array($user) ) {
          if( isset($user['locale'][$locale['pk_c_code']])) {
            if(isset($user['locale'][$locale['pk_c_code']]['s_info'])) {
              $info = $user['locale'][$locale['pk_c_code']]['s_info'];
            }
          }
        }
        self::info_textarea('s_info', $locale['pk_c_code'], $info);
      if($num_locales>1) { echo '</div>'; };
    }
    if($num_locales>1) { echo '</div>'; };
  }

  static public function country_select($countries, $user = null) {
    if(is_array($countries) && count($countries) > 1) {
      parent::generic_select('countryId', $countries, 'pk_c_code', 's_name', __('Select a country...'), (isset($user['fk_c_country_code'])) ? $user['fk_c_country_code'] : null);
    } else {
      parent::generic_input_text('country', ( !empty($user['s_country']) ? $user['s_country'] : @$countries[0]['s_name']));
      parent::generic_input_hidden('countryId', '');
    }
  }

  static public function country_text($user = null) {
    parent::generic_input_text('country', (isset($user['s_country'])) ? $user['s_country'] : null);
  }

  static public function region_select($regions, $user = null) {
    if(is_array($regions) && count($regions) >= 1) {
      parent::generic_select('regionId', $regions, 'pk_i_id', 's_name', __('Select a region...'), (isset($user['fk_i_region_id'])) ? $user['fk_i_region_id'] : null);
    } else {
      parent::generic_input_text('region', (isset($user['s_region'])) ? $user['s_region'] : null);
    }
  }

  static public function region_text($user = null) {
    parent::generic_input_text('region', (isset($user['s_region'])) ? $user['s_region'] : null);
  }

  static public function city_select($cities, $user = null) {
    if(is_array($cities) && count($cities) >= 1) {
      parent::generic_select('cityId', $cities, 'pk_i_id', 's_name', __('Select a city...'), (isset($user['fk_i_city_id'])) ? $user['fk_i_city_id'] : null);
    } else {
      parent::generic_input_text('city', (isset($user['s_city'])) ? $user['s_city'] : null);
    }
  }

  static public function city_text($user = null) {
    parent::generic_input_text('city', (isset($user['s_city'])) ? $user['s_city'] : null);
  }

  static public function city_area_text($user = null) {
    parent::generic_input_text('cityArea', (isset($user['s_city_area'])) ? $user['s_city_area'] : null);
  }

  static public function address_text($user = null) {
    parent::generic_input_text('address', (isset($user['s_address'])) ? $user['s_address'] : null);
  }

  static public function zip_text($user = null) {
    parent::generic_input_text('zip', (isset($user['s_zip'])) ? $user['s_zip'] : null);
  }

  static public function is_company_select($user = null, $user_label = null, $company_label = null) {
    $options = array(
      array( 'i_value' => '0', 's_text' => ($user_label?$user_label:__('User')) )
      ,array( 'i_value' => '1', 's_text' => ($company_label?$company_label:__('Company')) )
    );

    parent::generic_select( 'b_company', $options, 'i_value', 's_text', null, (isset($user['b_company'])) ? $user['b_company'] : null );
  }

  static public function user_select($users){
    Form::generic_select('userId', $users, 'pk_i_id', 's_name',  __('All') , NULL );
  }

  static public function js_validation() {
    ?>
    <script type="text/javascript">
    $(document).ready(function(){
      // Code for form validation
      $("form[name=register]").validate({
        rules: {
          s_name: {
            required: true
          },
          s_email: {
            required: true,
            email: true
          },
          s_password: {
            required: true,
            minlength: 5
          },
          s_password2: {
            required: true,
            minlength: 5,
            equalTo: "#s_password"
          }
        },
        messages: {
          s_name: {
            required: "<?php _e("Name: this field is required"); ?>."
          },
          s_email: {
            required: "<?php _e("Email: this field is required"); ?>.",
            email: "<?php _e("Invalid email address"); ?>."
          },
          s_password: {
            required: "<?php _e("Password: this field is required"); ?>.",
            minlength: "<?php _e("Password: enter at least 5 characters"); ?>."
          },
          s_password2: {
            required: "<?php _e("Second password: this field is required"); ?>.",
            minlength: "<?php _e("Second password: enter at least 5 characters"); ?>.",
            equalTo: "<?php _e("Passwords don't match"); ?>."
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
    });
    </script>
    <?php
  }

  static public function js_validation_old() {
    ?>
    <script type="text/javascript">
    $(document).ready(function(){
      $('#s_name').focus(function(){
        $('#s_name').css('border', '');
      });

      $('#s_email').focus(function(){
        $('#s_email').css('border', '');
      });

      $('#s_password').focus(function(){
        $('#s_password').css('border', '');
        $('#password-error').css('display', 'none');
      });

      $('#s_password2').focus(function(){
        $('#s_password2').css('border', '');
        $('#password-error').css('display', 'none');
      });
    });

    function checkForm() {
      var num_errors = 0;
      if( $('#s_name').val() == '' ) {
        $('#s_name').css('border', '1px solid red');
        num_errors = num_errors + 1;
      }
      if( $('#s_email').val() == '' ) {
        $('#s_email').css('border', '1px solid red');
        num_errors = num_errors + 1;
      }
      if( $('#s_password').val() != $('#s_password2').val() ) {
        $('#password-error').css('display', 'block');
        num_errors = num_errors + 1;
      }
      if( $('#s_password').val() == '' ) {
        $('#s_password').css('border', '1px solid red');
        num_errors = num_errors + 1;
      }
      if( $('#s_password2').val() == '' ) {
        $('#s_password2').css('border', '1px solid red');
        num_errors = num_errors + 1;
      }
      if(num_errors > 0) {
        return false;
      }

      return true;
    }
    </script>
    <?php
  }

  static public function js_validation_edit() {
    ?>
    <script type="text/javascript">
    $(document).ready(function(){
      // Code for form validation
      $("form[name=register]").validate({
        rules: {
          s_name: {
            required: true
          },
          s_email: {
            required: true,
            email: true
          },
          s_password: {
            minlength: 5
          },
          s_password2: {
            minlength: 5,
            equalTo: "#s_password"
          }
        },
        messages: {
          s_name: {
            required: "<?php _e("Name: this field is required"); ?>."
          },
          s_email: {
            required: "<?php _e("Email: this field is required"); ?>.",
            email: "<?php _e("Invalid email address"); ?>."
          },
          s_password: {
            minlength: "<?php _e("Password: enter at least 5 characters"); ?>."
          },
          s_password2: {
            minlength: "<?php _e("Second password: enter at least 5 characters"); ?>.",
            equalTo: "<?php _e("Passwords don't match"); ?>."
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
    });
    </script>
    <?php
  }

  static public function location_javascript($path = 'front') {
  ?>
    <script type="text/javascript">
    $(document).ready(function(){
      $("#countryId").on("change",function(){
        var pk_c_code = $(this).val();
        <?php if($path=="admin") { ?>
          var url = '<?php echo osc_admin_base_url(true)."?page=ajax&action=regions&countryId="; ?>' + pk_c_code;
        <?php } else { ?>
          var url = '<?php echo osc_base_url(true)."?page=ajax&action=regions&countryId="; ?>' + pk_c_code;
        <?php }; ?>
        var result = '';

        if(pk_c_code != '') {

          $("#regionId").attr('disabled',false);
          $("#cityId").attr('disabled',true);
          $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            success: function(data){
              var length = data.length;
              if(length > 0) {
                result += '<option value=""><?php _e("Select a region..."); ?></option>';
                for(key in data) {
                  result += '<option value="' + data[key].pk_i_id + '">' + data[key].s_name + '</option>';
                }
                $("#region").before('<select name="regionId" id="regionId" ></select>');
                $("#region").remove();

                $("#city").before('<select name="cityId" id="cityId" ></select>');
                $("#city").remove();

              } else {
                result += '<option value=""><?php _e('No results') ?></option>';
                $("#regionId").before('<input type="text" name="region" id="region" />');
                $("#regionId").remove();

                $("#cityId").before('<input type="text" name="city" id="city" />');
                $("#cityId").remove();
              }
              $("#regionId").html(result);
              $("#cityId").html('<option selected value=""><?php _e("Select a city..."); ?></option>');
            }
           });
         } else {
           // add empty select
           $("#region").before('<select name="regionId" id="regionId" ><option value=""><?php _e("Select a region..."); ?></option></select>');
           $("#region").remove();

           $("#city").before('<select name="cityId" id="cityId" ><option value=""><?php _e("Select a city..."); ?></option></select>');
           $("#city").remove();

           if( $("#regionId").length > 0 ){
             $("#regionId").html('<option value=""><?php _e("Select a region..."); ?></option>');
           } else {
             $("#region").before('<select name="regionId" id="regionId" ><option value=""><?php _e("Select a region..."); ?></option></select>');
             $("#region").remove();
           }
           if( $("#cityId").length > 0 ){
             $("#cityId").html('<option value=""><?php _e("Select a city..."); ?></option>');
           } else {
             $("#city").before('<select name="cityId" id="cityId" ><option value=""><?php _e("Select a city..."); ?></option></select>');
             $("#city").remove();
           }

          $("#regionId").attr('disabled',true);
          $("#cityId").attr('disabled',true);
         }
      });

      $("#regionId").on("change",function(){
        var pk_c_code = $(this).val();
        <?php if($path=="admin") { ?>
          var url = '<?php echo osc_admin_base_url(true)."?page=ajax&action=cities&regionId="; ?>' + pk_c_code;
        <?php } else { ?>
          var url = '<?php echo osc_base_url(true)."?page=ajax&action=cities&regionId="; ?>' + pk_c_code;
        <?php }; ?>

        var result = '';

        if(pk_c_code != '') {

          $("#cityId").attr('disabled',false);
          $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            success: function(data){
              var length = data.length;
              if(length > 0) {
                result += '<option selected value=""><?php _e("Select a city..."); ?></option>';
                for(key in data) {
                  result += '<option value="' + data[key].pk_i_id + '">' + data[key].s_name + '</option>';
                }
                $("#city").before('<select name="cityId" id="cityId" ></select>');
                $("#city").remove();
              } else {
                result += '<option value=""><?php _e('No results') ?></option>';
                $("#cityId").before('<input type="text" name="city" id="city" />');
                $("#cityId").remove();
              }
              $("#cityId").html(result);
            }
           });
         } else {
          $("#cityId").attr('disabled',true);
         }
      });


      if( $("#regionId").attr('value') == "") {
        $("#cityId").attr('disabled',true);
      }

      if( $("#countryId").prop('type').match(/select-one/) ) {
        if( $("#countryId").attr('value') == "") {
          $("#regionId").attr('disabled',true);
        }
      }
    });
    </script>
  <?php
  }
    
    
  static public function upload_profile_img() {
    ?>
    <?php
      $dim = osc_profile_img_dimensions();

      if($dim == '') {
        $dim = '240x240';
      }

      $dim = explode('x', $dim);

      $def_width = (int)$dim[0];
      $def_height = (int)$dim[1];
      $aspect = round($def_width/$def_height, 2);
    ?>

    <a href="#" class="btn btn-primary start-image-upload"><?php _e('Upload new picture'); ?></a>
    <a href="#" class="btn btn-secondary btn-next remove-profile-picture"><?php _e('Remove'); ?></a>


    <style>
    .pp-uploader {background:#ddd;padding:20px;}
    .row.img-buttons {margin-top:10px;width:100%;clear:both;}
    .user-img {margin:0 0 10px 0;}
    .pp-uploader .img-left {width:calc(100% - 140px);display:inline-block;position:relative;}
    .pp-uploader .img-left .cropper-container {max-width:100%;}
    .btn.cancel {float:right;}
    .img-preview img {max-width:100%;max-height:100%;width:auto;height:auto;}
    .pp-uploader .img-left {width:100%;}
    .img-preview {overflow:hidden;width:180px!important;height:<?php echo 180*(1/$aspect); ?>px!important;background:#ddd;}
    </style>


    <input type="file" name="image" class="upload-image" style="display:none;" accept=".jpg,.jpeg,.png,.gif"/>  
    <input type="hidden" name="pp_blob"/>  

    <div class="pp-uploader" style="display:none;">
      <div class="img-container">
        <div class="row">
          <div class="img-left">
          <img src="<?php echo osc_user_profile_img_url(osc_logged_user_id()); ?>" class="sample-image" id="sample-image" />
          </div>
        </div>

        <div class="row img-buttons">
          <button type="button" class="btn btn-primary crop"><?php _e('Save'); ?></button>
          <button type="button" class="btn btn-secondary btn-next img-rotate"><?php _e('Rotate'); ?></button>

          <button type="button" class="btn btn-next btn-secondary cancel"><?php _e('Cancel'); ?></button>
        </div>
      </div>
    </div>

    <script>
    $(document).ready(function(){
      var image = document.getElementById('sample-image');
      var defaultImage = $('.img-preview img').prop('src');

      //var image = $('.pp-uploader img.sample-image');
      var cropper = null;

      $('input.upload-image').change(function(event){
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
          alert('<?php echo osc_esc_js(__('Only formats are allowed')); ?>: '+fileExtension.join(', '));
          return false;
        }

        if(cropper === null) {
          cropper = new Cropper(image, {
          aspectRatio: <?php echo $aspect; ?>,
          viewMode: 2,
          preview:'.img-preview' 
          });
        }

        var files = event.target.files;

        var done = function(url){
          image.src = url;

          $('.pp-uploader').show(0);
          $('.start-image-upload, .remove-profile-picture').hide(0);

          cropper.replace(image.src);   
          $('.img-preview img').attr('src', image.src);   
        };

        if(files && files.length > 0) {
          reader = new FileReader();
          reader.onload = function(event) {
          done(reader.result);
          };
          
          reader.readAsDataURL(files[0]);
        }
      });


      $('.btn.img-rotate').click(function(){
        cropper.rotate(90);
      });

      $('.btn.cancel').click(function(e){
        e.preventDefault();
        $('input.upload-image').val('');
        $('.start-image-upload, .remove-profile-picture').show(0);
        $('.pp-uploader').hide(0); 
        cropper.destroy();
        cropper = null;

        $('.img-preview img').attr('style', '').attr('src', defaultImage);
      });

      $('.btn.crop').click(function(){
      $(this).addClass('btn-loading-nofa');

      canvas = cropper.getCroppedCanvas({
        width: <?php echo $def_width; ?>,
        height: <?php echo $def_height; ?>,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high'
      });

      canvas.toBlob(function(blob){
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function(){
          var base64data = reader.result;
          $('input[name="pp_blob"]').val(base64data).change();
        }
      }, 'image/jpeg', 1);

      });

      $('.btn.start-image-upload').on('click', function(e) {
        e.preventDefault();
        $('input.upload-image').click();
      });


      $('input[name="pp_blob"]').on('change', function(e) {
        e.preventDefault();
        $(this).closest('form').submit();
      });


      $('.btn.remove-profile-picture').on('click', function(e) {
        e.preventDefault();

        $.ajax({
          url: '<?php echo osc_base_url(true); ?>?page=ajax&action=remove_profile_img',
          method: 'POST',
          dataType: 'json',
          success: function(data)  {
            if(data.error == 0) {
              $('.user-img img').attr('src', data.message);
            } else {
              console.log(data);
            }
          }
        });
      });  
    });
    </script>
    <?php
  }
}

/* file end: ./oc-includes/osclass/frm/User.form.class.php */