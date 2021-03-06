<?php if ( ! defined( 'ABS_PATH' ) ) {
	exit( 'ABS_PATH is not loaded. Direct access is not allowed.' );
}

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


class WebSecBaseModel extends SecBaseModel
{
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * @return bool
   */
  public function isLogged()
  {
    return osc_is_web_user_logged_in();
  }

  //destroying current session
  public function logout()
  {
    //destroying session
    $locale = Session::newInstance()->_get('userLocale');
    Session::newInstance()->session_destroy();
    Session::newInstance()->_drop('userId');
    Session::newInstance()->_drop('userName');
    Session::newInstance()->_drop('userEmail');
    Session::newInstance()->_drop('userPhone');
    Session::newInstance()->session_start();
    Session::newInstance()->_set( 'userLocale', $locale);

    Cookie::newInstance()->pop('oc_userId');
    Cookie::newInstance()->pop('oc_userSecret');
    Cookie::newInstance()->set();
  }

  public function showAuthFailPage()
  {
    if( Params::getParam('page') === 'ajax') {
      echo json_encode(array('error' => 1, 'msg' => __('Session timed out')));
      exit;
    } else {
      $this->redirectTo( osc_user_login_url() );
      exit;
    }
  }
}

/* file end: ./oc-includes/osclass/core/WebSecBaseModel.php */