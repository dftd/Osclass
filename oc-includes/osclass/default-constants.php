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

if (!defined('OSCLASS_VERSION')){
  define('OSCLASS_VERSION', '4.4.0');
} 

if(!defined('MULTISITE')) {
  define('MULTISITE', 0);
}

if(!defined('OC_ADMIN')) {
  define('OC_ADMIN', false);
}

if(!defined('LIB_PATH')) {
  define('LIB_PATH', ABS_PATH . 'oc-includes/');
}

if(!defined('CONTENT_PATH')) {
  define('CONTENT_PATH', ABS_PATH . 'oc-content/');
}

if(!defined('WEB_PATH')) {  // this is needed during installation only, as then WEB_PATH is defined in config.php
  $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
  define('WEB_PATH', $protocol . $_SERVER['HTTP_HOST'] . '/');
}

if(!defined('CONTENT_WEB_PATH')) {
  define('CONTENT_WEB_PATH', WEB_PATH . 'oc-content/');
}

if(!defined('THEMES_PATH')) {
  define('THEMES_PATH', CONTENT_PATH . 'themes/');
}

if(!defined('THEMES_WEB_PATH')) {
  define('THEMES_WEB_PATH', CONTENT_WEB_PATH . 'themes/');
}

if(!defined('PLUGINS_PATH')) {
  define('PLUGINS_PATH', CONTENT_PATH . 'plugins/');
}

if(!defined('PLUGINS_WEB_PATH')) {
  define('PLUGINS_WEB_PATH', CONTENT_WEB_PATH . 'plugins/');
}

if(!defined('TRANSLATIONS_PATH')) {
  define('TRANSLATIONS_PATH', CONTENT_PATH . 'languages/');
}

if(!defined('TRANSLATIONS_WEB_PATH')) {
  define('TRANSLATIONS_WEB_PATH', CONTENT_WEB_PATH . 'languages/');
}

if(!defined('UPLOADS_PATH')) {
  define('UPLOADS_PATH', CONTENT_PATH . 'uploads/');
}

if(!defined('UPLOADS_WEB_PATH')) {
  define('UPLOADS_WEB_PATH', CONTENT_WEB_PATH . 'uploads/');
}

if(!defined('OSC_DEBUG_DB')) {
  define('OSC_DEBUG_DB', false);
}

if(!defined('OSC_DEBUG_DB_LOG')) {
  define('OSC_DEBUG_DB_LOG', false);
}

if(!defined('OSC_DEBUG_DB_EXPLAIN')) {
  define('OSC_DEBUG_DB_EXPLAIN', false);
}

if(!defined('OSC_DEBUG')) {
  define('OSC_DEBUG', false);
}

if(!defined('OSC_DEBUG_LOG')) {
  define('OSC_DEBUG_LOG', false);
}

if(!defined('OSC_MEMORY_LIMIT')) {
  define('OSC_MEMORY_LIMIT', '64M');
}

if ( function_exists( 'memory_get_usage' ) && ( (int) @ini_get( 'memory_limit' ) < abs( (int) OSC_MEMORY_LIMIT ) )) {
  @ini_set('memory_limit', OSC_MEMORY_LIMIT);
}

if(!defined('CLI')) {
  define('CLI', false);
}

if(!defined('OSC_CACHE_TTL')) {
  define('OSC_CACHE_TTL', 60);
}

if (!defined('OSCLASS_AUTHOR')){
  define('OSCLASS_AUTHOR', 'OSCLASSPOINT');
} 