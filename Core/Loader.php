<?php
class Loader {
    /**
     * @var string Action to be executed.
     */
    protected $action = 'index';

    /**
     * Authorization function.
     */
    public function authenticate() {
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authorization = $_SERVER['HTTP_AUTHORIZATION'];
        } else {
            if (function_exists('apache_request_headers')) {
                $headers = apache_request_headers();
                $authorization = $headers['HTTP_AUTHORIZATION'];
            }
        }

        // Check if authorization data were sent
        $authorization = base64_decode(substr($authorization, 6));
        if (!(strlen($authorization) === 0 || strcasecmp($authorization, ":" )  === 0)) {
            list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':', $authorization);
        }

        // If not authenticated show login dialog
        if (DBMS_AUTH && (!isset($_SERVER['PHP_AUTH_USER']) || !($_SERVER['PHP_AUTH_USER'] === DBMS_USERNAME && $_SERVER['PHP_AUTH_PW'] === DBMS_PASSWORD))) {
            header('WWW-Authenticate: Basic realm="DBMS Interface"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Access Denied';

            exit();
        }

        return $this;
    }

    /**
     * Dispatcher
     */
    public function dispatch() {
        $action = $this->getAction() . 'Action';
        $this->$action();
    }

    /**
     * Get current action.
     *
     * @return string Action requested.
     */
    protected function getAction() {
        if (isset($_GET['a'])) {
            $action = $_GET['a'];
            if (in_array("{$action}Action", get_class_methods(get_class($this)))) {
                $this->action = $action;
            }
        }

        return $this->action;
    }

    public function indexAction() {
        echo 'Index page';
    }

    /**
     * Loader singleton.
     *
     * @return Loader
     */
    public static function instance() {
        static $instance;
        if (!($instance instanceof self)) {
            $instance = new self();
        }

        return $instance;
    }
}