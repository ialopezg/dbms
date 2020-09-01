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
define('DBMS_ROOT_PATH', dirname(__FILE__) . DS);
/**
 * Core path. Libraries and other tools will be located in this path.
 */
define('DBMS_CORE_PATH', DBMS_ROOT_PATH . 'Core' . DS);
/**
 * Application path.
 */
define('DBMS_APP_PATH', DBMS_ROOT_PATH . 'App' . DS);

/*
 *--------------------------------------------------------------------------
 * Application Settings
 *--------------------------------------------------------------------------
 */

/**
 * Application base path.
 */
$config['base_path'] = DBMS_ROOT_PATH;
/**
 * Debug mode.
 */
$config['debug'] = true;
/**
 * Site name.
 */
$config['site_name'] = 'DBMS';
/**
 * Site webmaster email.
 */
$config['admin_email'] = 'admin@domain.com';