<?php
require_once 'config.php';

require_once DBMS_CORE_PATH . 'CommonFunctions.php';

register_shutdown_function('shutdown_function');
set_error_handler('error_handler');
set_exception_handler('exception_handler');
ini_set('display_errors', 'off');
error_reporting(E_ALL ^ E_NOTICE);

// Loader object
require_once DBMS_CORE_PATH . 'Loader.php';

Loader::instance()
    ->authenticate();