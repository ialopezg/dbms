<?php

/**
 * ExceptionManager class
 */
class ExceptionManager {
    protected $ob_level;

    public function __construct() {
        $this->ob_level = ob_get_level();

        return $this;
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