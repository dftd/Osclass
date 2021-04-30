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


class SecBaseModel extends BaseModel
{
  public function __construct()
  {
    parent::__construct ();

    //Checking granting...
    if (!$this->isLogged()) {
      //If we are not logged or we do not have permissions -> go to the login page
      $this->logout();
      $this->showAuthFailPage();
    }
  }

  //granting methods

  /**
   * @param $grant
   */
  public function setGranting( $grant )
  {
    $this->grant = $grant;
  }

  //destroying current session
  public function logout()
  {
    //destroying session
    Session::newInstance()->session_destroy();
  }

  public function doModel() {}

  /**
   * @param $file
   */
  public function doView( $file ) {
  }
}

/* file end: ./oc-includes/osclass/core/SecBaseModel.php */