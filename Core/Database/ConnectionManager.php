<?php
defined('DS') || define('DS', DIRECTORY_SEPARATOR);

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

    /**
     * Returns a list containing database drivers supported.
     *
     * @return array Driver list if exists.
     * @throws DBException
     */
    public static function getDrivers() {
        $path = dirname(__FILE__) . DS . 'Drivers';
        if (!is_dir($path)) {
            if (function_exists('show_error')) {
                show_error('No database drivers were found.');
            } else {
                throw new DBException('No database drivers were found.');
            }
        }

        foreach (new DirectoryIterator($path) as $file) {
            $result = [];

            $pi = pathinfo($file);
            if ($file->isDot() || $file->getExtension() !== 'php') {
                continue;
            }

            $result[] = substr($file->getFilename(), 0, strlen($file->getFilename()) - (strlen($file->getExtension()) + 1));
        }

        return $result;
    }

    public static function hasConnections() {
        return count(self::$connections);
    }
}
