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


define('CACHE_PATH', osc_uploads_path());

/**
 * This is the simplest cache service on earth.
 *
 * @author Osclass
 * @version 1.0
 */
class Cache {

  private $objectKey;
  private $expiration;

  /**
   * Cache constructor.
   *
   * @param   $objectKey
   * @param int $expiration
   */
  public function __construct( $objectKey , $expiration = 900 /* 15 minutes */ ) {
    $this->objectKey = $objectKey;
    $this->expiration = $expiration;
  }

  public function __destruct() {
  }

  /**
   * @return true if the object is cached and has not expired, false otherwise.
   */
  public function check() {
    $path = $this->preparePath();
    if ( ! file_exists( $path ) ) {
    return false;
    }

    if(time() - filemtime($path) > $this->expiration) {
      unlink($path);
      return false;
    }

    return true;
  }

  /**
   * Stores the object passed as parameter in the cache backend (filesystem).
   *
   * @param $object
   */
  public function store($object) {
    $serialized = serialize($object);
    file_put_contents($this->preparePath(), $serialized);
  }

  /**
   * Returns the data of the current cached object.
   */
  public function retrieve() {
    $content = file_get_contents($this->preparePath());
    return unserialize($content);
  }

  /**
   * Constructs the path to object in filesystem.
   */
  private function preparePath() {
    return CACHE_PATH . $this->objectKey . '.cache';
  }
}