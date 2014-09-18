<?php
/**
 * The absolute path to the project (site)
 */
define('PATH_SITE', __DIR__);

/**
 * Communication with the outside world
 */
define('PATH_EXCHANGE', PATH_SITE . '/exchange');

/**
 * The location of the site log
 */
define('PATH_LOG', PATH_SITE . '/log');

/**
 * Db connect config
 */
define('DB_HOST', 'localhost');
define('DB_LOGIN', 'test');
define('DB_PASSWORD', 'test');
define('DB_NAME', 'test_xml');

/**
 * error handlers
 */
set_error_handler(['Zero_Logs', 'Handler_Error'], 2147483647);
set_exception_handler(['Zero_Logs', 'Handler_Exception']);

/**
 * Connection classes
 *
 * Setting up automatic downloads of files with the required classes
 *
 * @param string $class_name
 * @return bool
 */
function __autoload($class_name)
{
    if ( class_exists($class_name) )
        return true;
    if ( file_exists($path = PATH_SITE . '/' . str_replace('_', '/', $class_name) . '.php') )
    {
        require_once $path;
        return true;
    }
    return false;
}

/**
 * Debug output to the browser
 *
 * @param mixed $var variable
 */
function pre($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

