<?php
if (!function_exists('')) {
    /**
     * Increases or decreases the brightness of a color by a percentage of the current brightness.
     *
     * @param string $hex_code Supported formats: `#FFF`, `#FFFFFF`, `FFF`, `FFFFFF`
     * @param float $adjustment A number between -1 and 1. E.g. 0.3 = 30% lighter; -0.4 = 40% darker.
     *
     * @return string A color string.
     */
    function adjust_color_bright($hex_code, $adjustment) {
        $hex_code = ltrim($hex_code, '#');

        if (strlen($hex_code) == 3) {
            $hex_code = $hex_code[0] . $hex_code[0] . $hex_code[1] . $hex_code[1] . $hex_code[2] . $hex_code[2];
        }

        $hex_code = array_map('hexdec', str_split($hex_code, 2));

        foreach ($hex_code as & $color) {
            $adjustableLimit = $adjustment < 0 ? $color : 255 - $color;
            $adjustAmount = ceil($adjustableLimit * $adjustment);

            $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
        }

        return '#' . implode($hex_code);
    }
}

if (!function_exists('config_item')) {
    /**
     * Returns a config item value.
     *
     * @param string $item Config item name requested.
     *
     * @return mixed|null The config item value requested, if present, otherwise null.
     */
    function config_item($item) {
        static $config;

        if (empty($config)) {
            $config['app'] = get_config();
        }

        return isset($config['app'][$item]) ? $config['app'][$item] : null;
    }
}

if (!function_exists('error_handler')) {
    /**
     * Custom error handler.
     *
     * @param string $error_severity Error severity.
     * @param string $error_message Error message.
     * @param string $error_file Error file where error occurs.
     * @param string $error_line Error file line
     * @param null $error_context
     */
	function error_handler($error_severity, $error_message, $error_file, $error_line) {
	    exception_handler(new ErrorException($error_message, 0, $error_severity, $error_file, $error_line));
	}
}

if (!function_exists('friendly_error_type')) {
    /**
     * Gets the name of error constants.
     *
     * @param int $type Error type.
     *
     * @return string The error name.
     */
    function friendly_error_type($type) {
        static $levels = null;
        if (!$levels) {
            $levels = [];
            foreach (get_defined_constants(true)['Core'] as $key => $value) {
                if (strpos($key, 'E_') !== 0) {
                    continue;
                }
                $levels[$value] = substr($key, 2);
            }
        }

        return (isset($levels[$type]) ? $levels[$type] : "Error #{$type}");
    }
}

if (!function_exists('get_config')) {
    /**
     * Loads main config file.
     *
     * @param array $replace Dynamically values to be replaced.
     *
     * @return array An array containing the defaul config.
     */
    function get_config(Array $replace = []) {
        static $config;

        if (empty($config)) {
            $file = APP_PATH . 'config' . DS . 'app.php';
            if (file_exists($file)) {
                require($file);
            }
        }

        if (file_exists(APP_PATH . 'Config' . DS . ENVIRONMENT . DS . 'app.php')) {
            require(APP_PATH . 'config' . DS . ENVIRONMENT . DS . 'app.php');
        }

        if (!isset($config) || !is_array($config)) {
            set_status_header(503);
            echo 'The main config file does not appear to be formatted correctly.';
            exit(3); // EXIT_CONFIG
        }

        foreach ($replace as $key=> $value) {
            $config[$key] = $value;
        }

        return $config;
    }
}

if (!function_exists('log_message')) {
    /**
     * Log a message into the default log system.
     *
     * @param int $level Log message level. Accepts: DEBUG, ERROR, INFO and WARNING messages.
     * @param string $message Message to be logged.
     */
    function log_message($level, $message) {
        static $logger;

        if (!class_exists('Log')) {
            require_once CORE_PATH . 'Log.php';
        }

        if (!($logger instanceof Log)) {
            $logger = new Log();
        }
        $logger->write($level, $message);
    }
}

if (!function_exists('set_status_header')) {
    function set_status_header($status_code = 500, $message = '') {
        $status_code = abs($status_code);

        if (empty($status_code) || !is_numeric($status_code)) {
            // TODO: Implement friendly error message
            die('HTTP status code must be a numeric value.');
        }

        if (empty($message)) {
            $http_status_codes = [
                503	=> 'Service Unavailable',
            ];

            if (isset($http_status_codes[$status_code])) {
                $message = $http_status_codes[$status_code];
            } else {
                // TODO: Implement friendly error message
                die('No such text message available. Please, supply a message text for your status code.');
            }
        }

        if (strpos(PHP_SAPI, 'cgi') === 0) {
            header("Status: {$status_code} {$message}", true);

            return;
        }

        $server_protocol = isset($_SERVER['SERVER_PROTOCOL']) && in_array($_SERVER['SERVER_PROTOCOL'], [
            'HTTP/1.0', 'HTTP/1.1', 'HTTP/2', 'HTTP/2.0'
            ], true) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
        header("{$server_protocol} {$status_code} {$message}", true, $status_code);
    }
}

if (!function_exists('shutdown_function')) {
    function shutdown_function() {
        $error = error_get_last();
        if ($error && $error['type'] === E_ERROR) {
            error_handler($error['type'], $error['message'], $error['file'], $error['line']);
        }
    }
}