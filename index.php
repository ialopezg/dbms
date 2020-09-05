<?php
/*
 *--------------------------------------------------------------------------
 * File System Settings
 *--------------------------------------------------------------------------
 */

/**
 * Alias for DIRECTORY_SEPARATOR
 */
define('DS', DIRECTORY_SEPARATOR);
/**
 * Front-Controller path. Appoint to this file path container.
 */
define('ROOT_PATH', dirname(__FILE__) . DS);
/**
 * Core path. Libraries and other tools will be located in this path.
 */
define('CORE_PATH', ROOT_PATH . 'Core' . DS);
/**
 * Application path.
 */
define('APP_PATH', ROOT_PATH . 'App' . DS);
/**
 * Application logs path.
 */
define('LOGS_PATH', APP_PATH . 'Logs' . DS);
/**
 * Views templates path.
 */
define('VIEWS_PATH', APP_PATH . 'Views' . DS);

// Load default configurations
require_once APP_PATH . 'config/constants.php';
// Load default configurations
require_once ROOT_PATH . 'config.php';
// Load common functions
require_once CORE_PATH . 'CommonFunctions.php';

set_error_handler('error_handler');
set_exception_handler('exception_handler');
register_shutdown_function('shutdown_function');

// Loader object
require_once CORE_PATH . 'Loader.php';

Loader::instance()
    ->authenticate();
//    ->dispatch();