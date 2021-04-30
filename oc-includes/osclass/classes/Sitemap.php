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
 * This class dynamically creates a XML Sitemap ready to send to Google, Yahoo and others.
 * @author  Osclass
 */
class Sitemap {

  private $urls;
  private $validFrequencies = array('always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never');

  public function __construct() {
    $this->urls = array();
  }

  /**
   * @param    $loc
   * @param string $changeFreq
   * @param float  $priority
   * @param null   $lastMod
   */
  public function addURL( $loc , $changeFreq = 'daily' , $priority = 0.7 , $lastMod = null ) {
    $this->urls[] = array(
      'loc' => $loc,
      'lastMod' => $lastMod,
      'changeFreq' => $changeFreq,
      'priority' => $priority
    );
  }

  public function toStdout() {
    header('Content-type: text/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>', PHP_EOL;
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', PHP_EOL;

    foreach($this->urls as $url) {
      echo '<url>', PHP_EOL;
      echo '<loc>', $url['loc'], '</loc>', PHP_EOL;
      echo '<lastmod>', $url['lastMod'], '</lastmod>', PHP_EOL;
      echo '<changefreq>', $url['changeFreq'], '</changefreq>', PHP_EOL;
      echo '<priority>', $url['priority'], '</priority>', PHP_EOL;
      echo '</url>', PHP_EOL;
    }

    echo '</urlset>', PHP_EOL;
  }
}