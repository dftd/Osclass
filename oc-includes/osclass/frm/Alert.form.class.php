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
* Class AlertForm
*/
class AlertForm extends Form {
  /**
  * @return bool
  */
  public static function user_id_hidden() {
    parent::generic_input_hidden('alert_userId', osc_logged_user_id() );
    return true;
  }

  /**
  * @return bool
  */
  public static function email_hidden() {
    parent::generic_input_hidden('alert_email', osc_logged_user_email() );
    return true;
  }

  /**
  * @return string
  */
  public static function default_email_text() {
    return __('Enter your e-mail');
  }

  /**
  * @return bool
  */
  public static function email_text() {
    $value = '';
    if( osc_logged_user_email() == '' ){
      $value = self::default_email_text();
    }
    parent::generic_input_text('alert_email', $value );
    return true;
  }

  /**
  * @return bool
  */
  public static function page_hidden() {
    parent::generic_input_hidden('page', 'search');
    return true;
  }

  /**
  * @return bool
  */
  public static function alert_hidden() {
    parent::generic_input_hidden('alert', osc_search_alert() );
    return true;
  }
}