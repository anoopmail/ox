<?php

define('OW_URL_HOME', 'http://makantoday.com/EDMW/');

define('OW_DB_HOST', 'localhost');
define('OW_DB_PORT', null);
define('OW_DB_USER', 'makasxtl_oxwa828');
define('OW_DB_PASSWORD', '6@Pd1)oS5v');
define('OW_DB_NAME', 'makasxtl_oxwa828');

define('OW_DB_PREFIX', 'ow_');

define('OW_DIR_USERFILES', OW_DIR_ROOT.'ow_userfiles'.DS);
define('OW_DIR_STATIC', OW_DIR_ROOT.'ow_static'.DS);
define('OW_URL_STATIC', OW_URL_HOME.'ow_static/');
define('OW_URL_USERFILES', OW_URL_HOME.'ow_userfiles/');
define('OW_DIR_PLUGINFILES', OW_DIR_ROOT.'ow_pluginfiles/');

define('OW_PASSWORD_SALT', '55430b2c561b4');

define('OW_DIR_CORE', OW_DIR_ROOT.'ow_core'.DS);
define('OW_DIR_INC', OW_DIR_ROOT.'ow_includes'.DS);
define('OW_DIR_LIB', OW_DIR_ROOT.'ow_libraries'.DS);
define('OW_DIR_UTIL', OW_DIR_ROOT.'ow_utilities'.DS);
define('OW_DIR_PLUGIN', OW_DIR_ROOT.'ow_plugins'.DS);
define('OW_DIR_THEME', OW_DIR_ROOT.'ow_themes'.DS);
define('OW_DIR_SYSTEM_PLUGIN', OW_DIR_ROOT.'ow_system_plugins'.DS);
define('OW_DIR_SMARTY', OW_DIR_ROOT.'ow_smarty'.DS);

define('OW_USE_CLOUDFILES', false);

if ( defined('OW_CRON') )
{
    define('OW_DEBUG_MODE', false);
    define('OW_DEV_MODE', false);
    define('OW_PROFILER_ENABLE', false);
}
else
{
    /**
    * Make changes in this block if you want to enable DEV mode and DEBUG mode
    */

    define('OW_DEBUG_MODE', false);
    define('OW_DEV_MODE', false);
    define('OW_PROFILER_ENABLE', false);
}