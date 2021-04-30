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
 * Log DAO
 */
class Log extends DAO
{
  /**
   *
   * @var type
   */
  private static $instance;

  /**
   * @return \Log|\type
   */
  public static function newInstance()
  {
    if( !self::$instance instanceof self ) {
      self::$instance = new self;
    }
    return self::$instance;
  }

  /**
   *
   */
  public function __construct()
  {
    parent::__construct();
    $this->setTableName('t_log');
    $array_fields = array(
      'dt_date',
      's_section',
      's_action',
      'fk_i_id',
      's_data',
      's_ip',
      's_who',
      'fk_i_who_id'
    );
    
    $this->setFields($array_fields);
  }

  /**
   * Insert a log row.
   *
   * @access public
   * @since  unknown
   *
   * @param string  $section
   * @param string  $action
   * @param integer $id
   * @param string  $data
   * @param string  $who
   * @param     $whoId
   *
   * @return boolean
   */
  public function insertLog($section, $action, $id, $data, $who, $whoId)
  {
    //if ( Params::getServerParam('REMOTE_ADDR') == '' ) {
      // CRON.
    //  $_SERVER['REMOTE_ADDR']= '127.0.0.1';
    //}

    $array_set = array(
      'dt_date'     => date('Y-m-d H:i:s'),
      's_section'   => $section,
      's_action'    => $action,
      'fk_i_id'     => $id,
      's_data'    => $data,
      's_ip'      => (osc_get_ip() <> '' ? osc_get_ip() : '127.0.0.1'), //Params::getServerParam('REMOTE_ADDR'),
      's_who'     => $who,
      'fk_i_who_id'   => $whoId
    );
    
    return $this->dao->insert($this->getTableName(), $array_set);
  }
}

/* file end: ./oc-includes/osclass/model/Log.php */