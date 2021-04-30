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
 * Helper Translation
 * @package Osclass
 * @subpackage Helpers
 * @author Osclass
 */

/**
 * Translate strings
 *
 * @since unknown
 *
 * @param string $key
 * @param string $domain
 * @return string
 */
function __($key, $domain = 'core')
{
  $gt = Translation::newInstance()->_get();
  $string = $gt->dgettext($domain, $key);
  return osc_apply_filter('gettext', $string);
}

/**
 * Translate strings and echo them
 *
 * @since unknown
 *
 * @param string $key
 * @param string $domain
 */
function _e($key, $domain = 'core')
{
  echo __($key, $domain);
}

/**
 * Translate string (flash messages)
 *
 * @since unknown
 *
 * @param string $key
 * @return string
 */
function _m($key)
{
  return __($key, 'messages');
}

/**
 * Retrieve the singular or plural translation of the string.
 *
 * @since 2.2
 *
 * @param string $single_key
 * @param string $plural_key
 * @param int $count
 * @param string $domain
 * @return string
 */
function _n($single_key, $plural_key, $count, $domain = 'core')
{
  $gt = Translation::newInstance()->_get();
  $string = $gt->dngettext($domain, $single_key, $plural_key, $count);
  return osc_apply_filter('ngettext', $string);
}

/**
 * Retrieve the singular or plural translation of the string.
 *
 * @since 2.2
 *
 * @param string $single_key
 * @param string $plural_key
 * @param int $count
 * @return string
 */
function _mn($single_key, $plural_key, $count)
{
  return _n($single_key, $plural_key, $count, 'messages');
}

/* file end: ./oc-includes/osclass/helpers/hTranslations.php */