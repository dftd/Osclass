<?php
// Multi-site setup
define('MULTISITE', 0);

// MySql database host
define('DB_HOST', 'localhost');

// MySql database username
define('DB_USER', 'username');

// MySql database password
define('DB_PASSWORD', 'password');

// MySql database name
define('DB_NAME', 'database_name');

// MySql database table prefix
define('DB_TABLE_PREFIX', 'oc_');

// Relative web url
define('REL_WEB_URL', 'rel_here');

// Web address - modify here for SSL version of site
define('WEB_PATH', 'http://localhost');


// *************************************** //
// ** OPTIONAL CONFIGURATION PARAMETERS ** //
// *************************************** //

// Enable debugging
// define('OSC_DEBUG', true);
// define('OSC_DEBUG_DB', true);
// define('OSC_DEBUG_LOG', true);


// Demo mode
//define('DEMO', true);
//define('DEMO_THEMES', true);
//define('DEMO_PLUGINS', true);


// PHP memory limit (ideally should be more than 128MB)
// define('OSC_MEMORY_LIMIT', 64);


// MemCache caching option (database queries cache)
// define('OSC_CACHE', 'memcache');
// $_cache_config[] = array('default_host' => 'localhost', 'default_port' => 11211, 'default_weight' => 1);


// Increase default login time for user
// session_set_cookie_params(2592000);
// ini_set('session.gc_maxlifetime', 2592000);

?>