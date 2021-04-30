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
 * Model database for Country table
 *
 * @package Osclass
 * @subpackage Model
 * @since unknown
 */
class Country extends DAO
{
  /**
   *
   * @var Country
   */
  private static $instance;

  /**
   * @return \Country
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
    $this->setTableName('t_country');
    $this->setPrimaryKey('pk_c_code');
    $this->setFields( array('pk_c_code', 's_name', 's_name_native', 's_phone_code', 's_currency', 's_slug') );
  }

  /**
   * Find a country by its ISO code
   *
   * @access public
   * @since unknown
   * @param $code
   * @return array
   */
  public function findByCode($code)
  {
    if(trim($code) == '') { 
      return array();
    }
    
    $this->dao->select();
    $this->dao->from($this->getTableName());
    $this->dao->where('pk_c_code', $code);
    $result = $this->dao->get();

    if($result == false) {
      return array();
    }
    return $result->row();
  }

  /**
   * Find a country by its name
   *
   * @access public
   * @since unknown
   * @param $name
   * @return array
   */
  public function findByName($name)
  {
    if(trim($name) == '') { 
      return array();
    }
    
    $this->dao->select();
    $this->dao->from($this->getTableName());
    $this->dao->where(sprintf('(s_name="%s" OR s_name_native="%s")', $name, $name));

    $result = $this->dao->get();
    if($result == false) {
      return array();
    }
    return $result->row();
  }


  /**
   * Get all the rows from the table t_country
   *
   * @access public
   * @since unknown
   * @return array
   */
  public function listAll()
  {
    $this->dao->select($this->getFields());
    $this->dao->from($this->getTableName());
    $this->dao->orderBy('s_name', 'ASC');
    $result = $this->dao->get();

    if($result == false) {
      return array();
    }

    return $result->result();
  }
  

  /**
   * List names of all the countries. Used for location import.
   *
   * @access public
   * @since  unknown
   * @return array
   */
  public function listNames() {
    $result = $this->dao->query(sprintf('SELECT s_name FROM %s ORDER BY s_name ASC', $this->getTableName()));
    if($result == false) {
      return array();
    }
    return array_column($result->result(), 's_name');
  }

  /**
   * Function that work with the ajax file
   *
   * @access public
   * @since unknown
   * @param $query
   * @return array
   */
  public function ajax($query)
  {
    $this->dao->select('pk_c_code as id, s_name as label, s_name_native as label_native, s_name as value');
    $this->dao->from($this->getTableName());
    $this->dao->like('s_name', $query, 'after');
    $this->dao->orLike('s_name_native', $query, 'after');
    $this->dao->limit(5);
    $result = $this->dao->get();
    if($result == false) {
      return array();
    }

    $return = $result->result();
    $output = array();
    if(count($return) > 0 && osc_get_current_user_locations_native() == 1) {
      foreach($return as $r) {
        $row = $r;
        $row['label_original'] = '';

        if(@$row['label_native'] <> '') {
          $row['label_original'] = $row['label'];
          $row['label'] = $row['label_native'];
          $row['value'] = $row['label_native'];
        }

        $output[] = $row;
      }
    } else {
      $output = $return;
    }

    return $output;
  }


  /**
   *  Delete a country with its regions, cities,..
   *
   * @access public
   * @since  2.4
   *
   * @param $pk
   *
   * @return int number of failed deletions or 0 in case of none
   * @throws \Exception
   */
  public function deleteByPrimaryKey($pk) {
    $mRegions = Region::newInstance();
    $aRegions = $mRegions->findByCountry($pk);
    $result = 0;
    foreach($aRegions as $region) {
      $result += $mRegions->deleteByPrimaryKey($region['pk_i_id']);
    }
    Item::newInstance()->deleteByCountry($pk);
    CountryStats::newInstance()->delete(array('fk_c_country_code' => $pk));
    User::newInstance()->update(array('fk_c_country_code' => null, 's_country' => ''), array('fk_c_country_code' => $pk));
    if(!$this->delete(array('pk_c_code' => $pk))) {
      $result++;
    }
    return $result;
  }

  /**
   * Find a location by its slug
   *
   * @access public
   * @since 3.2.1
   * @param $slug
   * @return array
   */
  public function findBySlug($slug)
  {
    if(trim($slug) == '') { 
      return array();
    }
    
    $this->dao->select();
    $this->dao->from($this->getTableName());
    $this->dao->where('s_slug', $slug);
    $result = $this->dao->get();

    if($result == false) {
      return array();
    }
    return $result->row();
  }

  /**
   * Find a locations with no slug
   *
   * @access public
   * @since 3.2.1
   * @return array
   */
  public function listByEmptySlug()
  {
    $this->dao->select();
    $this->dao->from($this->getTableName());
    $this->dao->where('s_slug', '');
    $result = $this->dao->get();

    if($result == false) {
      return array();
    }
    return $result->result();
  }


}

/* file end: ./oc-includes/osclass/model/Country.php */