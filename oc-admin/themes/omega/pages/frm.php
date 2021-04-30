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


osc_enqueue_script('tiny_mce');

$page     = __get('page');
$templates  = __get('templates');
$meta     = json_decode(@$page['s_meta'], true);

$template_selected = (isset($meta['template']) && $meta['template']!='')?$meta['template']:'default';
$locales = OSCLocale::newInstance()->listAllEnabled();

function customFrmText($return = 'title') {
  $page = __get('page');
  $text = array();
  
  if( isset($page['pk_i_id']) ) {
    $text['edit']     = true;
    $text['title']    = __('Edit page');
    $text['action_frm'] = 'edit_post';
    $text['btn_text']   = __('Save changes');
  } else {
    $text['edit']     = false;
    $text['title']    = __('Add page');
    $text['action_frm'] = 'add_post';
    $text['btn_text']   = __('Add page');
  }

  return $text[$return];
}

function customPageHeader() { ?><h1><?php _e('Pages'); ?></h1><?php }

osc_add_hook('admin_page_header','customPageHeader');

function customPageTitle($string) {
  return sprintf('%s - %s', customFrmText('title'), $string);
}

osc_add_filter('admin_title', 'customPageTitle');


//customize Head
function customHead() { 
  ?>
  <script type="text/javascript">
    tinyMCE.init({
      mode : "textareas",
      width: "100%",
      height: "440px",
      language: 'en',
      content_style: "body {font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;}",
      theme_advanced_toolbar_align : "left",
      theme_advanced_toolbar_location : "top",
      plugins : [
        "advlist autolink lists link image charmap preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
      ],
      entity_encoding : "raw",
      theme_advanced_buttons1_add : "forecolorpicker,fontsizeselect",
      theme_advanced_buttons2_add: "media",
      theme_advanced_buttons3: "",
      theme_advanced_disable : "styleselect,anchor",
      relative_urls : false,
      remove_script_host : false,
      convert_urls : false,
      paste_data_images: true,
      images_upload_url: '<?php echo osc_base_url(); ?>oc-admin/themes/omega/tinyMceUploader.php',
      images_upload_base_path: '<?php echo osc_base_path(); ?>oc-content/uploads/page-images/',
      images_upload_credentials: true,
      images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '<?php echo osc_base_url(); ?>oc-admin/themes/omega/tinyMceUploader.php');
        xhr.onload = function() {
          var json;

          if (xhr.status != 200) {
            failure('HTTP Error: ' + xhr.status);
            return;
          }
          
          json = JSON.parse(xhr.responseText);

          if (!json || typeof json.location != 'string') {
            failure('Invalid JSON: ' + xhr.responseText);
            return;
          }
          
          success(json.location);
        };
        
        formData = new FormData();
        //formData.append('file', blobInfo.blob(), fileName(blobInfo));

        if( typeof(blobInfo.blob().name) !== undefined ) {
          fileName = blobInfo.blob().name;
        } else {
          fileName = blobInfo.filename();
        }

        formData.append('file', blobInfo.blob(), fileName);

        xhr.send(formData);
      }
    });
  </script>
  <?php
}
osc_add_hook('admin_header','customHead', 10);

osc_current_admin_theme_path('parts/header.php'); 
?>

<h2 class="render-title"><?php echo customFrmText('title'); ?></h2>
<div id="item-form">
  <?php printLocaleTabs(); ?>
   <form action="<?php echo osc_admin_base_url(true); ?>" method="post" class="editpage">
    <input type="hidden" name="page" value="pages" />
    <input type="hidden" name="action" value="<?php echo customFrmText('action_frm'); ?>" />
    <?php PageForm::primary_input_hidden($page); ?>
    <?php printLocaleTitlePage($locales, $page); ?>
    <div>
      <label><?php _e('Internal name'); ?></label>
      <?php PageForm::internal_name_input_text($page); ?>
      <div class="flashmessage flashmessage-warning flashmessage-inline">
        <p><?php _e('Used to quickly identify this page'); ?></p>
      </div>
      <span class="help"></span>
    </div>
    
    <?php if(count($templates)>0) { ?>
      <div>
        <label><?php _e('Page template'); ?></label>
        <select name="meta[template]">
          <option value="default" <?php if($template_selected=='default') { echo 'selected="selected"'; }; ?>><?php _e('Default template'); ?></option>
          <?php foreach($templates as $template) { ?>
            <option value="<?php echo $template?>" <?php if($template_selected==$template) { echo 'selected="selected"'; }; ?>><?php echo $template; ?></option>
          <?php }; ?>
        </select>
      </div>
    <?php }; ?>
    
    <div class="input-description-wide">
      <?php printLocaleDescriptionPage($locales, $page); ?>
    </div>
    
    <div class="form-controls">
      <div class="form-label-checkbox">
        <label><?php PageForm::link_checkbox($page); ?> <?php _e('Add link to footer in front-office'); ?></label>
      </div>

      <div class="form-label-checkbox">
        <label><?php PageForm::index_checkbox($page); ?> <?php _e('Allow search engines to index this page'); ?></label>
      </div>
    </div>
    
    <div><?php osc_run_hook('page_meta'); ?></div>
    <div class="clear"></div>
    
    <div class="form-actions">
      <?php if( customFrmText('edit') ) { ?>
      <a href="javascript:history.go(-1)" class="btn"><?php _e('Cancel'); ?></a>
      <?php } ?>
      <input type="submit" value="<?php echo osc_esc_html(customFrmText('btn_text')); ?>" class="btn btn-submit" />
    </div>
  </form>
</div>

<?php osc_current_admin_theme_path('parts/footer.php'); ?>