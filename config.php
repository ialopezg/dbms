<?php
/**
 * @package Core
 */

/**
 * Application environment.
 */
define('ENVIRONMENT', getenv('DBMS_ENV') ? getenv('DBMS_ENV') : 'development');
switch (ENVIRONMENT) {
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', 'on');
        break;
    case 'testing':
    case 'production':
        ini_set('display_errors', 'off');
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        break;
    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1);
}

/**
 * Site name.
 */
$config['site_name'] = 'DBMS';
/**
 * Site webmaster email.
 */
$config['admin_email'] = 'admin@domain.com';

/*
 *--------------------------------------------------------------------------
 * Auth Settings
 *--------------------------------------------------------------------------
 */

/**
 * DBMS username.
 */
define('DBMS_USERNAME', 'dbms');
/**
 * DBMS password.
 */
define('DBMS_PASSWORD', 'dbms');
/**
 * Enable or disable DBMS Authentication Module.
 */
define('DBMS_AUTH', strlen(DBMS_USERNAME) && strlen(DBMS_PASSWORD));