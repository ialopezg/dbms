<?php

/**
 * ExceptionManager class
 */
class ExceptionManager {
    protected $ob_level;

    public function __construct() {
        $this->ob_level = ob_get_level();
    }

    /**
     * Returns a name of an error constant.
     *
     * @param int|string $type Error type (supports: E_ALL, 1)
     *
     * @return string The error name
     */
    public function get_level($type) {
        $levels = $this->get_levels();

        return (isset($levels[$type]) ? $levels[$type] : "Error #{$type}");
    }

    /**
     * Returns an associative array with the names of all error constants.
     *
     * @return array The error name.
     */
    public function get_levels() {
        static $levels = null;

        if (!$levels) {
            $levels = [];
            foreach (get_defined_constants(true)['Core'] as $key => $value) {
                if (strpos($key, 'E_') !== 0) {
                    continue;
                }

                $levels[$value] = ucwords(substr(str_replace('_', ' ', strtolower($key)), 2));
            }
        }

        return $levels;
    }

    /**
     * Log an exception.
     *
     * @param int $level Log message level.
     * @param string $message Message to be logged.
     * @param string $file File were occurs the exception.
     * @param string $line Line were occurs the exception.
     */
    public function log_exception($level, $message, $file, $line) {
        $level = $this->get_level($level);
        log_message('error', "Severity: {$level} - {$message} in ${file} on line ${line}");
    }

    /**
     * Shows an error message in html form.
     *
     * @param string $heading Error heading message.
     * @param string $message Error message.
     * @param string $template HTML template to be used.
     * @param int $status_code Error HTTP status code
     *
     * @return string Output to be displayed.
     */
    public function show_error($heading, $message, $template = 'general', $status_code = 500) {
        $template_path = config_item('error_views_path');
        if (empty($template_path)) {
            $template_path = VIEWS_PATH . 'errors' . DS;
        } else {
            $template_path = rtrim(config_item('error_templates_path'), '/\\') . DS;
        }

        set_status_header($status_code);
        $message = '<p>' . (is_array($message) ? implode("\n\t", $message) : $message) . '</p>';

        if (ob_get_level() > $this->ob_level) {
            ob_end_flush();
        }
        ob_start();
        include("{$template_path}{$template}.php");
        $buffer = ob_get_contents();
        ob_end_clean();

        return $buffer;
    }
}