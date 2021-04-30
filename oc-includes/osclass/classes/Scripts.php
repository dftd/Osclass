<?php

use MatthiasMullie\Minify;

/**
 * Scripts enqueue class.
 *
 * @since 3.1.1
 */
class Scripts extends Dependencies {
  private static $instance;

  /**
   * @return \Scripts
   */
  public static function newInstance()
  {
    if(!self::$instance instanceof self) {
      self::$instance = new self;
    }
    return self::$instance;
  }

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Add script to be loaded
   *
   * @param $id
   * @param $url
   * @param $dependencies mixed, it could be an array or a string
   */
  public function registerScript($id, $url, $dependencies = null)
  {
    $this->register($id, $url, $dependencies);
  }

  /**
   * Remove script to not be loaded
   *
   * @param $id
   */
  public function unregisterScript($id)
  {
    $this->unregister($id);
  }

  /**
   * Enqueu script to be loaded
   *
   * @param $id
   */
  public function enqueuScript($id)
  {
    $this->queue[$id] = $id;
  }

  /**
   * Remove script to not be loaded
   *
   * @param $id
   */
  public function removeScript($id)
  {
    unset($this->queue[$id]);
  }

  /**
   *  Get the scripts urls
   */
  public function getScripts()
  {
    $scripts = array();
    parent::order();
    foreach($this->resolved as $id) {
      if( isset($this->registered[$id]['url']) ) {
        $scripts[$id] = $this->registered[$id]['url'];   // update 420, $scripts[] -> $scripts[$id]
      }
    }
    return $scripts;
  }

  /**
   *  Print the HTML tags to load the scripts
   */
  public function printScripts()
  {
    $compress = osc_js_minify();
    $minifier = new Minify\JS('');
    $banned_pages = array_filter(array_map('trim', explode(',', osc_js_banned_pages()))); 
    $current_page = (osc_get_osclass_location() == '' ? 'home' : osc_get_osclass_location());

    if(osc_js_merge() && !in_array($current_page, $banned_pages) && (!defined('OC_ADMIN') || OC_ADMIN !== true)) {
      $name = '';
      $content = '';
      $internal = array();
      $banned_words = array_filter(array_map('trim', explode(',', osc_js_banned_words()))); 

      // first collect internal names and check if file exists
      foreach($this->getScripts() as $id => $url) {
        if(trim($url) != '') {
          if (strpos($url, '?v=') !== false) {
            $url = substr($url, 0, strpos($url, '?v='));
          }

          $path = str_replace(osc_base_url(), osc_base_path(), $url);
          
          if (strpos($url, osc_base_url()) !== false && !osc_string_contains_array($url, $banned_words)) {
            $internal[] = $id;
            $modtime = filemtime($path);
            $name .= $id . '_' . $modtime . ';';
          }
        }
      }

      $name = md5($name) . '.js';
      $save_path = osc_uploads_path() . 'minify/';
      $save_url = str_replace(osc_base_path(), osc_base_url(), $save_path);

      // if file does not exists, generate new
      if(!file_exists($save_path . $name)) {
        foreach($this->getScripts() as $id => $url) {
          if(trim($url) != '') {
            if(in_array($id, $internal)) {
              if (strpos($url, '?v=') !== false) {
                $url = substr($url, 0, strpos($url, '?v='));
              }

              $path = str_replace(osc_base_url(), osc_base_path(), $url);
              
              if (strpos($url, osc_base_url()) !== false && !osc_string_contains_array($url, $banned_words)) {
                if($compress) {
                  $minifier->add($path);
                } else {
                  $file = file_get_contents($path);
                  $content .= $file;
                }
              }
            }
          }
        }

        if($compress) {
          $minifier->minify($save_path . $name);
        } else {
          file_put_contents($save_path . $name, $content);
        }
      }
     
      // print merged, it should contain all dependencies
      echo '<script type="text/javascript" src="' . osc_apply_filter('theme_url', $save_url . $name) . '"></script>' . PHP_EOL;

      foreach($this->getScripts() as $id => $script) {
        if(!in_array($id, $internal)) {
          if($script!=='') {
            echo '<script type="text/javascript" src="' . osc_apply_filter('theme_url', $script) . '"></script>' . PHP_EOL;
          }
        }
      }      
    } else {
      foreach($this->getScripts() as $id => $script) {
        if($script!=='') {
          echo '<script type="text/javascript" src="' . osc_apply_filter('theme_url', $script) . '"></script>' . PHP_EOL;
        }
      }
    }
  }
}