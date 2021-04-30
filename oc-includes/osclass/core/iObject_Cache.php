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


interface iObject_Cache {
  /**
   * @param     $key
   * @param     $data
   * @param int $expire
   *
   * @return mixed
   */
  public function add( $key , $data , $expire = 0 );

  /**
   * @param     $key
   * @param     $data
   * @param int $expire
   *
   * @return mixed
   */
  public function set( $key , $data , $expire = 0 );

  /**
   * @param      $key
   * @param null $found
   *
   * @return mixed
   */
  public function get( $key , &$found = null );

  /**
   * @param $key
   *
   * @return mixed
   */
  public function delete( $key );
    public function flush();
    public function stats();
    public function _get_cache(); // return string 
    public static function is_supported();


    public function __destruct();
}

/* file end: ./oc-includes/osclass/core/iObject_Cache.php */