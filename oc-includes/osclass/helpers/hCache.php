<?php
/*
 * Copyright 2020 OsclassPoint.com
 *
 * Osclass maintained & developed by OsclassPoint.com
 * you may not use this file except in compliance with the License.
 * You may download copy of Osclass at
 *
 *   https://osclass-classifieds.com/download
 *
 * Software is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */


/**
 * @param   $key
 * @param   $data
 * @param int $expire
 *
 * @return bool
 * @throws \Exception
 */
function osc_cache_add( $key , $data , $expire = 0 ) {
  $key .= osc_current_user_locale();
  return Object_Cache_Factory::newInstance()->add($key, $data, $expire);
}


/**
 * @return mixed
 * @throws \Exception
 */
function osc_cache_close() {
  return Object_Cache_Factory::newInstance()->close();
}


/**
 * @param $key
 *
 * @return bool
 * @throws \Exception
 */
function osc_cache_delete( $key ) {
  $key .= osc_current_user_locale();
  return Object_Cache_Factory::newInstance()->delete($key);
}


/**
 * @return bool
 * @throws \Exception
 */
function osc_cache_flush() {
  return Object_Cache_Factory::newInstance()->flush();
}

function osc_cache_init() {
  try {
  Object_Cache_Factory::newInstance();
  } catch ( Exception $e ) {
  }
}


/**
 * @param $key
 * @param $found
 *
 * @return bool|mixed
 * @throws \Exception
 */
function osc_cache_get( $key , &$found ) {
  $key .= osc_current_user_locale();
  return Object_Cache_Factory::newInstance()->get($key, $found);
}


/**
 * @param   $key
 * @param   $data
 * @param int $expire
 *
 * @return bool
 * @throws \Exception
 */
function osc_cache_set( $key , $data , $expire = 0 ) {
  $key .= osc_current_user_locale();
  return Object_Cache_Factory::newInstance()->set($key, $data, $expire);
}
