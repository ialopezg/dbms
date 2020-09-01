<?php
require_once 'config.php';

require_once DBMS_CORE_PATH . 'CommonFunctions.php';

register_shutdown_function('shutdown_function');
set_error_handler('error_handler');
set_exception_handler('exception_handler');
ini_set('display_errors', 'off');
error_reporting(E_ALL);

var_dump([
    'constants' => get_defined_constants(true)['user'],
    'variables' => get_defined_vars(),
    'files' => get_included_files()
]);