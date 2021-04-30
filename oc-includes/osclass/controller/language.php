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


/**
 * Class CWebLanguage
 */
class CWebLanguage extends BaseModel
{
  public function __construct()
  {
    parent::__construct();
    osc_run_hook( 'init_language' );
  }

  // business layer...
  public function doModel()
  {
    $locale = Params::getParam('locale');

    if(preg_match('/.{2}_.{2}/', $locale)) {
      Session::newInstance()->_set( 'userLocale', $locale);
    }

    $redirect_url = '';
    if(Params::getServerParam('HTTP_REFERER', false, false) != '') {
      $redirect_url = Params::getServerParam('HTTP_REFERER', false, false);
    } else {
      $redirect_url = osc_base_url(true);
    }

    $this->redirectTo($redirect_url);
  }

  // hopefully generic...

  /**
   * @param $file
   *
   * @return mixed|void
   */
  public function doView( $file ) {
  }
}

/* file end: ./language.php */