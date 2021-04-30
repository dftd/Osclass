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
 * Class Logger
 */
abstract class Logger
{

  /**
   * Log a message with the INFO level.
   *
   * @param string $message
   *
   * @param null   $caller
   *
   */
  abstract public function info($message = '', $caller = null );

  /**
   * Log a message with the WARN level.
   *
   * @param string $message
   *
   * @param null   $caller
   *
   */
  abstract public function warn($message = '', $caller = null );

  /**
   * Log a message with the ERROR level.
   *
   * @param string $message
   *
   * @param null   $caller
   */
  abstract public function error($message = '', $caller = null );

  /**
   * Log a message with the DEBUG level.
   * @param string $message
   * @param null   $caller
   */
  abstract public function debug($message = '', $caller = null );

  /**
   * Log a message object with the FATAL level including the caller.
   * @param string $message
   * @param null   $caller
   */
  abstract public function fatal($message = '', $caller = null );
}

/* file end: ./oc-includes/osclass/Logger/Logger.php */