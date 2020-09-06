<?php
class ConnectionManager {
    /**
     * @var array Connection list.
     */
    protected static $connections = [];
    /**
     * @var bool Flag to know if class has been initialized.
     */
    private static $initialized = false;
    /**
     * @var string Config file path.
     */
    protected $path;

    public static function initialize($params = '') {
        if (self::$initialized) {
            return;
        }

        if ($params !== '') {
            $params = APP_PATH . DS . 'config' . DS;
        }
        if (!file_exists($filepath = $params . 'database.php')
            && !(file_exists($filepath = $params . ENVIRONMENT . DS . 'database.php'))) {
            show_error('The configuration file database.php does not exist. Please, provide the path where look for it.');
        }

        self::$initialized = true;
    }

    public static function hasConnections() {
        return count(self::$connections);
    }
}
