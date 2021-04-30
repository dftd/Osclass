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


class CAdminTools extends AdminSecBaseModel {
  function __construct() {
    parent::__construct();
  }

  //Business Layer...
  function doModel() {
    parent::doModel();

    switch($this->action) {
      case('cleanup'):    // calling info view 
        $this->doView('tools/cleanup.php');
        break;

      case('info'):       // calling info view
        $this->doView('tools/info.php');
        break;

      case('debug'):       // calling info view
        $this->doView('tools/debug.php');
        break;
        
      case('import'):     // calling import view
        $this->doView('tools/import.php');
        break;

      case('import_post'):  
        if(defined('DEMO')) {
          osc_add_flash_warning_message( _m("This action cannot be done because it is a demo site"), 'admin');
          $this->redirectTo(osc_admin_base_url(true) . '?page=tools&action=import');
        }
        
        // calling
        osc_csrf_check();
        $sql = Params::getFiles('sql');
        if( isset($sql['size']) && $sql['size'] != 0 ) {
          $content_file = file_get_contents($sql['tmp_name']);

          $conn = DBConnectionClass::newInstance();
          $c_db = $conn->getOsclassDb();
          $comm = new DBCommandClass($c_db);
          if ( $comm->importSQL($content_file) ) {
            osc_calculate_location_slug(osc_subdomain_type());
            osc_add_flash_ok_message( _m('Import complete'), 'admin');
          } else {
            osc_add_flash_error_message( _m('There was a problem importing data to the database'), 'admin');
          }
        } else {
          osc_add_flash_warning_message( _m('No file was uploaded'), 'admin');
        }
        
        @unlink($sql['tmp_name']);
        $this->redirectTo(osc_admin_base_url(true) . '?page=tools&action=import');
        break;

      case('category'):
        $this->doView('tools/category.php');
        break;

      case('category_post'):  if(defined('DEMO')) {
          osc_add_flash_warning_message( _m("This action cannot be done because it is a demo site"), 'admin');
          $this->redirectTo(osc_admin_base_url(true) . '?page=tools&action=category');
        }
        
        osc_update_cat_stats();
        osc_add_flash_ok_message(_m("Recount category stats has been successful"), 'admin');
        $this->redirectTo(osc_admin_base_url(true) . '?page=tools&action=category');
        break;

      case('locations'):
        $this->doView('tools/locations.php');
        break;

      case('locations_post'): 
        if(defined('DEMO')) {
          osc_add_flash_warning_message( _m("This action cannot be done because it is a demo site"), 'admin');
          $this->redirectTo(osc_admin_base_url(true) . '?page=tools&action=locations');
        }

        osc_update_location_stats(true);

        $this->redirectTo( osc_admin_base_url(true) . '?page=tools&action=locations' );
        break;

      case('upgrade'):
        if(defined('DEMO')) {
          osc_add_flash_warning_message( _m("This action cannot be done because it is a demo site"), 'admin');
          $this->redirectTo(osc_admin_base_url(true));
        }
        
        $this->doView('tools/upgrade.php');
        break;

      case 'version':
        $this->doView('tools/version.php');
        break;

      case('backup'):
        $this->doView('tools/backup.php');
        break;

      case('backup-sql'):
        if(defined('DEMO')) {
          osc_add_flash_warning_message( _m("This action cannot be done because it is a demo site"), 'admin');
          $this->redirectTo(osc_admin_base_url(true) . '?page=tools&action=backup');
        }
        
        osc_csrf_check();
        //databasse dump...
        if( Params::getParam('bck_dir') != '' ) {
          $path = trim( Params::getParam('bck_dir') );
          if(substr($path, -1, 1) != "/") {
             $path .= '/';
          }
        } else {
          $path = osc_base_path();
        }
        
        $filename = 'Osclass_mysqlbackup.' . date('YmdHis') . '.sql';

        switch ( osc_dbdump($path, $filename) ) {
          case(-1):
            $msg = _m('Path is empty');
            osc_add_flash_error_message( $msg, 'admin');
            break;

          case(-2):
            $msg = sprintf(_m('Could not connect with the database. Error: %s'), mysql_error());
            osc_add_flash_error_message( $msg, 'admin');
            break;

          case(-3):
            $msg = _m('There are no tables to back up');
            osc_add_flash_error_message( $msg, 'admin');
            break;

          case(-4):
            $msg = _m('The folder is not writable');
            osc_add_flash_error_message( $msg, 'admin');
            break;

          default:
            $msg = _m('Backup completed successfully');
            osc_add_flash_ok_message( $msg, 'admin');
            break;
        }
        
        $this->redirectTo( osc_admin_base_url(true) . '?page=tools&action=backup' );
        break;

      case('backup-sql_file'):
        if(defined('DEMO')) {
          osc_add_flash_warning_message( _m("This action cannot be done because it is a demo site"), 'admin');
          $this->redirectTo(osc_admin_base_url(true) . '?page=tools&action=backup');
        }
        
        //databasse dump...
        $filename = 'Osclass_mysqlbackup.' . date('YmdHis') . '.sql';
        $path = sys_get_temp_dir()."/";

        switch (osc_dbdump($path, $filename)) {
          case(-1):
            $msg = _m('Path is empty');
            osc_add_flash_error_message( $msg, 'admin');
            break;

          case(-2):
            $msg = sprintf(_m('Could not connect with the database. Error: %s'), mysql_error());
            osc_add_flash_error_message( $msg, 'admin');
            break;

          case(-3):
            $msg = sprintf(_m('Could not select the database. Error: %s'), mysql_error());
            osc_add_flash_error_message( $msg, 'admin');
            break;

          case(-4):
            $msg = _m('There are no tables to back up');
            osc_add_flash_error_message( $msg, 'admin');
            break;

          case(-5):
            $msg = _m('The folder is not writable');
            osc_add_flash_error_message( $msg, 'admin');
            break;

          default:
            $msg = _m('Backup completed successfully');
            osc_add_flash_ok_message( $msg, 'admin');
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($filename));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path.$filename));
            flush();
            readfile($path.$filename);
            exit;
            break;
        }
        
        $this->redirectTo( osc_admin_base_url(true) . '?page=tools&action=backup' );
        break;

      case('backup-zip_file'):
        if(defined('DEMO')) {
          osc_add_flash_warning_message( _m("This action cannot be done because it is a demo site"), 'admin');
          $this->redirectTo(osc_admin_base_url(true) . '?page=tools&action=backup');
        }
        
        $filename = "Osclass_backup." . date('YmdHis') . ".zip";
        $path = sys_get_temp_dir()."/";

        if (osc_zip_folder(osc_base_path(),$path. $filename)) {
          $msg = _m('Archived successfully!');
          osc_add_flash_ok_message( $msg, 'admin');
          header('Content-Description: File Transfer');
          header('Content-Type: application/octet-stream');
          header('Content-Disposition: attachment; filename='.basename($filename));
          header('Content-Transfer-Encoding: binary');
          header('Expires: 0');
          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
          header('Pragma: public');
          header('Content-Length: ' . filesize($path.$filename));
          flush();
          readfile($path.$filename);
          exit;
          
        } else {
          $msg = _m('Error, the zip file was not created in the specified directory');
          osc_add_flash_error_message( $msg, 'admin');
        }
        
        $this->redirectTo( osc_admin_base_url(true) . '?page=tools&action=backup' );
        break;

      case('backup-zip'):   if(defined('DEMO')) {
          osc_add_flash_warning_message( _m("This action cannot be done because it is a demo site"), 'admin');
          $this->redirectTo(osc_admin_base_url(true) . '?page=tools&action=backup');
        }
        
        //zip of the code just to back it up
        osc_csrf_check();
        if( Params::getParam('bck_dir') != '' ) {
          $archive_name = trim( Params::getParam('bck_dir') );
          if(substr(trim($archive_name), -1, 1) != "/") {
             $archive_name .= '/';
          }
          $archive_name = Params::getParam('bck_dir') . '/Osclass_backup.' . date('YmdHis') . '.zip';
        } else {
          $archive_name = osc_base_path() . "Osclass_backup." . date('YmdHis') . ".zip";
        }
        
        $archive_folder = osc_base_path();

        if ( osc_zip_folder($archive_folder, $archive_name) ) {
          $msg = _m('Archived successfully!');
          osc_add_flash_ok_message( $msg, 'admin');
        }else{
          $msg = _m('Error, the zip file was not created in the specified directory');
          osc_add_flash_error_message( $msg, 'admin');
        }
        
        $this->redirectTo( osc_admin_base_url(true) . '?page=tools&action=backup' );
        break;

      case('backup_post'):
        $this->doView('tools/backup.php');
        break;

      case('maintenance'): 
        if(defined('DEMO')) {
          osc_add_flash_warning_message( _m("This action cannot be done because it is a demo site"), 'admin');
          $this->doView('tools/maintenance.php');
          break;
        }
        
        $mode = Params::getParam('mode');
        if( $mode == 'on' ) {
          osc_csrf_check();
          $maintenance_file = osc_base_path() . '.maintenance';
          $fileHandler = @fopen($maintenance_file, 'w');
          
          if( $fileHandler ) {
            osc_add_flash_ok_message( _m('Maintenance mode is ON'), 'admin');
          } else {
            osc_add_flash_error_message( _m('There was an error creating the .maintenance file, please create it manually at the root folder'), 'admin');
          }
          
          fclose($fileHandler);
          $this->redirectTo( osc_admin_base_url(true) . '?page=tools&action=maintenance' );
          
        } else if( $mode == 'off' ) {
          osc_csrf_check();
          $deleted = @unlink(osc_base_path() . '.maintenance');
          if( $deleted ) {
            osc_add_flash_ok_message( _m('Maintenance mode is OFF'), 'admin');
          } else {
            osc_add_flash_error_message( _m('There was an error removing the .maintenance file, please remove it manually from the root folder'), 'admin');
          }
          
          $this->redirectTo( osc_admin_base_url(true) . '?page=tools&action=maintenance' );
        }
        
        $this->doView('tools/maintenance.php');
        break;

      case('cleanup_post'):
        if(defined('DEMO')) {
          osc_add_flash_warning_message( _m("This action cannot be done because it is a demo site"), 'admin');
          $this->redirectTo(osc_admin_base_url(true) . '?page=tools&action=cleanup');
        }

        $type = Params::getParam('type');
        $limit_days = 7;
        $limit_date = date('Y-m-d', strtotime('-' . $limit_days . ' days'));
        $res = true;

        if($type == 'items_inactive') {
          $data = osc_get_query_results(sprintf('SELECT * FROM %st_item WHERE b_active != 1 AND dt_pub_date <= "%s"', DB_TABLE_PREFIX, $limit_date));

          $manager = new ItemActions(true);
          if(is_array($data) && !empty($data)) {
            foreach($data as $d) {
              $manager->delete($d['s_secret'], $d['pk_i_id']);
            }
          } else {
            $res = false;
          }
        } else if($type == 'items_blocked_spam') {
          $data = osc_get_query_results(sprintf('SELECT * FROM %st_item WHERE b_enabled = 0 OR b_spam = 1', DB_TABLE_PREFIX));

          $manager = new ItemActions(true);
          if(is_array($data) && !empty($data)) {
            foreach($data as $d) {
              $manager->delete($d['s_secret'], $d['pk_i_id']);
            }
          } else {
            $res = false;
          }
        } else if($type == 'items_expired') {
          $data = osc_get_query_results(sprintf('SELECT * FROM %st_item WHERE dt_expiration <= "%s"', DB_TABLE_PREFIX, $limit_date));

          $manager = new ItemActions(true);
          if(is_array($data) && !empty($data)) {
            foreach($data as $d) {
              $manager->delete($d['s_secret'], $d['pk_i_id']);
            }
          } else {
            $res = false;
          }
        } else if($type == 'users_inactive') {
          $data = osc_get_query_results(sprintf('SELECT * FROM %st_user WHERE b_active != 1 AND dt_reg_date <= "%s"', DB_TABLE_PREFIX, $limit_date));

          $manager = User::newInstance();
          if(is_array($data) && !empty($data)) {
            foreach($data as $d) {
              Log::newInstance()->insertLog('user', 'delete', $d['pk_i_id'], $d['s_email'], 'admin', osc_logged_admin_id());
              $manager->deleteUser($d['pk_i_id']);
            }
          } else {
            $res = false;
          }
        } else if($type == 'users_blocked') {
          $data = osc_get_query_results(sprintf('SELECT * FROM %st_user WHERE b_enabled = 0', DB_TABLE_PREFIX));

          $manager = User::newInstance();
          if(is_array($data) && !empty($data)) {
            foreach($data as $d) {
              Log::newInstance()->insertLog('user', 'delete', $d['pk_i_id'], $d['s_email'], 'admin', osc_logged_admin_id());
              $manager->deleteUser($d['pk_i_id']);
            }
          } else {
            $res = false;
          }
        } else if($type == 'comments_inactive') {
          $data = osc_get_query_results(sprintf('SELECT * FROM %st_item_comment WHERE b_active != 1 AND dt_pub_date <= "%s"', DB_TABLE_PREFIX, $limit_date));

          $manager = ItemComment::newInstance();
          if(is_array($data) && !empty($data)) {
            foreach($data as $d) {
              $manager->delete(array('pk_i_id' => $d['pk_i_id']));
            }
          } else {
            $res = false;
          }
        } else if($type == 'comments_blocked') {
          $data = osc_get_query_results(sprintf('SELECT * FROM %st_item_comment WHERE b_enabled = 0', DB_TABLE_PREFIX));
          
          $manager = ItemComment::newInstance();
          if(is_array($data) && !empty($data)) {
            foreach($data as $d) {
              $manager->delete(array('pk_i_id' => $d['pk_i_id']));
            }
          } else {
            $res = false;
          }
        } 

        if($res) {
          osc_add_flash_ok_message( _m("Data cleaned up successfully"), 'admin');
        } else {
          osc_add_flash_error_message( _m("There was problem cleaning data (no data has been found)"), 'admin');
        }

        //$this->doView('tools/cleanup.php');
        //exit;
        $this->redirectTo(osc_admin_base_url(true) . '?page=tools&action=cleanup');
        exit;
        break;

      default:
        $this->doView('tools/info.php');
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

/* file end: ./oc-admin/tools.php */