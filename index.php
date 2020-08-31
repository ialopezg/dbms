<?php
/**
 * Alias for DIRECTORY_SEPARATOR
 */
define('DS', DIRECTORY_SEPARATOR);
/**
 * Front-Controller path. Appoint to this file path container.
 */
define('FC_PATH', dirname(__FILE__) . DS);
/**
 * Core path. Libraries and other tools will be located in this path
 */
define('CORE_PATH', FC_PATH . 'Core' . DS);
/**
 * Application path
 */
define('APP_PATH', FC_PATH . 'App' . DS);
/**
 * Views path
 */
define('VIEW_PATH', APP_PATH . 'Views' . DS);

error_reporting(E_ALL | E_ERROR);

var_dump(get_defined_constants(true)['user']);

