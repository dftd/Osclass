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
 *
 */
class Cron extends DAO
{
  /**
   *
   * @var type
   */
  private static $instance;

  /**
   * @return \Cron|\type
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
    $this->setTableName('t_cron');
    $this->setFields( array('e_type', 'd_last_exec', 'd_next_exec') );
  }

  /**
   * Return crons by type
   *
   * @access public
   * @since unknown
   *
   * @param string $type
   *
   * @return array|bool
   */
  public function getCronByType($type)
  {
    $this->dao->select();
    $this->dao->from($this->getTableName());
    $this->dao->where('e_type', $type);
    $result = $this->dao->get();

    if( $result->numRows == 0 ) {
      return false;
    }

    return $result->row();
  }
}

/* file end: ./oc-includes/osclass/model/Cron.php */