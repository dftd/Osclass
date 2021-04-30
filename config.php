<?php
// Multi-site setup
define('MULTISITE', 0);

// MySql database host
define('DB_HOST', 'localhost');

// MySql database username
define('DB_USER', 'root');

// MySql database password
define('DB_PASSWORD', '');

// MySql database name
define('DB_NAME', 'osclass');

// MySql database table prefix
define('DB_TABLE_PREFIX', 'oc_');

// Relative web url
define('REL_WEB_URL', '/osclass/');

// Web address - modify here for SSL version of site
define('WEB_PATH', 'http://localhost/osclass/');


// *************************************** //
// ** OPTIONAL CONFIGURATION PARAMETERS ** //
// *************************************** //

// Enable debugging
// define('OSC_DEBUG', true);
// define('OSC_DEBUG_DB', true);
// define('OSC_DEBUG_LOG', true);


// PHP memory limit (ideally should be more than 128MB+)
// define('OSC_MEMORY_LIMIT', 64);


// MemCache caching option (database queries cache)
// define('OSC_CACHE', 'memcache');
// $_cache_config[] = array('default_host' => 'localhost', 'default_port' => 11211, 'default_weight' => 1);


// Increase default login time for user
// session_set_cookie_params(2592000);
// ini_set('session.gc_maxlifetime', 2592000);

?>