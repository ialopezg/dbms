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

        $hexCode = array_map('hexdec', str_split($hex_code, 2));

        foreach ($hexCode as & $color) {
            $adjustableLimit = $adjustment < 0 ? $color : 255 - $color;
            $adjustAmount = ceil($adjustableLimit * $adjustment);

            $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
        }

        return '#' . implode($hexCode);
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
	function error_handler($error_severity, $error_message, $error_file, $error_line, $error_context = null) {
	    exception_handler(new ErrorException($error_message, 0, $error_severity, $error_file, $error_line));
	}
}

if (!function_exists('exception_handler')) {
    /**
     * Custom exception handler.
     *
     * @param Exception $e Exception occurred.
     */
    function exception_handler(Exception $e) {
        global $config;

        $body =     '<div style="width: 95%; margin: auto; border: 1px solid ' . adjust_color_bright('#dc3545', -0.25) . ';">';
        $body .=        '<div style="background-color: ' . adjust_color_bright('#dc3545', 0.1) . '; color: #ffffff; padding: 10px;">';
        $body .=            '<span style="padding-right: 10px; font-size: large; font-weight: bold;">( ! )</span>';
        $body .=            '<strong>Exception Occurred</strong>';
        $body .=        '</div>';
        $body .=        '<div style="display: flex; align-items: stretch;">';
        $body .=            '<div style="flex-grow: 1; padding-right: 10px; line-height: 30px; width: 15%; background-color: lightgray;  font-weight: bold; text-align: right;">';
        $body .=                '<div>Type:</div>';
        $body .=                '<div>Message:</div>';
        $body .=                '<div>File:</div>';
        $body .=                '<div>Line:</div>';
        $body .=            '</div>';
        $body .=            '<div style="flex-grow: 9; line-height: 30px; margin-left: 10px; width: 85%;">';
        $body .=                '<div>' . get_class($e) . '</div>';
        $body .=                '<div>' . $e->getMessage() . '</div>';
        $body .=                '<div>' . $e->getFile() . '</div>';
        $body .=                '<div>' . $e->getLine() . '</div>';
        $body .=            '</div>';
        $body .=        '</div>';
        $body .=    '</div>';
        if (isset($config['debug']) && $config['debug']) {
            print $body;
        } else {
            $message = '[' . date('Y-m-d H:m:i') . '] - Type: ' . get_class($e) . "; Message: {$e->getMessage()}; File: {$e->getFile()}; Line: {$e->getLine()}";
            $file = 'exceptions.log';
            $path = $config['base_path'] . 'tmp/logs';

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            file_put_contents($path . "/${file}", $message . PHP_EOL, FILE_APPEND);
            print   '<div style="width: 95%; margin: auto; border: 1px solid ' . adjust_color_bright('#dc3545', -0.25) . ';">';
            print       '<div style="background-color: ' . adjust_color_bright('#dc3545', 0.1) . '; color: #ffffff; padding: 10px;">';
            print           '<span style="padding-right: 10px; font-size: large; font-weight: bold;">( ! )</span>';
            print           '<strong>Exception Occurred</strong>';
            print       '</div>';
            print       '<div style="padding-left: 10px; padding-top: 5px;">';
            print           '<strong>' . $e->getMessage() . '</strong><br>';
            $subject = $config['site_name'] . ' >> Error occurred';
            print           '<p>Click <a href="mailto:' .  $config['admin_email'] . '?subject=' . $subject . '&body=' . $message . '">here</a> to send a report to your Web Administrator.</p>';
            print       '</div>';
            print   '</div>';
        }

        exit();
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