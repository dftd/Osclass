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


class AdminBaseModel extends BaseModel
{
  public function __construct()
  {
    parent::__construct();
    // @deprecated: to be removed
    
    osc_run_hook( 'init_admin' );
    osc_run_hook( 'init_admin_insecure' );
  }

  public function doModel() {}

  /**
   * @param $file
   */
  public function doView( $file ) {}
}

/* file end: ./oc-includes/osclass/core/AdminBaseModel.php */