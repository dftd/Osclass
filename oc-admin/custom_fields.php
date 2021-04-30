<?php if (!defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

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


class CAdminCFields extends AdminSecBaseModel {
  //specific for this class
  private $fieldManager;

  function __construct() {
    parent::__construct();

    //specific things for this class
    $this->fieldManager = Field::newInstance();
  }

  //Business Layer...
  function doModel() {
    parent::doModel();

    //specific things for this class
    switch( $this->action ) {
      default:
        $categories = Category::newInstance()->toTreeAll();
        $selected   = array();
        
        // nested select for 6 levels of nesting
        if(is_array($categories) && count($categories) > 0) {
          foreach($categories as $c) {
            $selected[] = $c['pk_i_id'];
            
            if(is_array($c['categories']) && count($c['categories']) > 0) {
              foreach($c['categories'] as $cc) {
                $selected[] = $cc['pk_i_id'];
                
                if(is_array($cc['categories']) && count($cc['categories']) > 0) {
                  foreach($cc['categories'] as $ccc) {
                    $selected[] = $ccc['pk_i_id'];
                    
                    if(is_array($ccc['categories']) && count($ccc['categories']) > 0) {
                      foreach($ccc['categories'] as $cccc) {
                        $selected[] = $cccc['pk_i_id'];
                        

                        if(is_array($cccc['categories']) && count($cccc['categories']) > 0) {
                          foreach($cccc['categories'] as $ccccc) {
                            $selected[] = $ccccc['pk_i_id'];
                            
                            if(is_array($ccccc['categories']) && count($ccccc['categories']) > 0) {
                              foreach($ccccc['categories'] as $cccccc) {
                                $selected[] = $cccccc['pk_i_id'];
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
        
        $this->_exportVariableToView('categories', $categories);
        $this->_exportVariableToView('default_selected', $selected);
        $this->_exportVariableToView('fields', $this->fieldManager->listAll());
        $this->doView("fields/index.php");
        break;
    }
  }

  //hopefully generic...
  function doView($file) {
    osc_run_hook("before_admin_html");
    osc_current_admin_theme_path($file);
    Session::newInstance()->_clearVariables();
    osc_run_hook("after_admin_html");
  }
}

/* file end: ./oc-admin/custom_fields.php */