<?php

/**
 * Class Log Service class.
 */
class Log {
    /**
     * Log date format.
     *
     * @var string
     */
    protected $date_format;
    /**
     * File permissions
     *
     * @var	int
     */
    protected $file_permissions = 0644;
    protected $levels = [
        'ALL' => 0,
        'DEBUG' => 1,
        'ERROR' => 2,
        'INFO' => 4,
        'WARNING' => 8
    ];
    protected $log_path;

    public function __construct() {
        global $config;

        $this->log_path = isset($config['log_path']) && !empty($config['log_path']) ? $config['log_path'] . DS : LOGS_PATH;
        if (!is_dir($this->log_path)) {
            mkdir($this->log_path, 0755, true);
        }

        $this->date_format = isset($config['log_date_format']) && !empty($config['log_date_format']) ? $config['log_date_format'] : 'Y-m-d H:i:s';

        $this->file_permissions = !empty($config['log_file_permissions']) && is_int($config['log_file_permissions']) ? $config['log_date_format'] : 0644;
    }

    /**
     * Format a message line.
     *
     * @param string $level Error level.
     * @param string $date Date of logging.
     * @param string $message Log message line.
     *
     * @return string A message properly formatted.
     */
    protected function format_message($level, $date, $message) {
        $spaces = strlen('warning');
        if (strlen($level) < $spaces) {
            for ($i = strlen($level); $i < $spaces; $i++) {
                $level .= ' ';
            }
        }
        return "[{$date}] - {$level} => {$message}" . PHP_EOL;
    }

    /**
     * Write a log line.
     *
     * @param string $level Error log level.
     * @param string $message Error log message.
     *
     * @return bool True if line was successfully wrote.
     */
    public function write($level, $message) {
        global $config;

        $level = strtoupper($level);

        $filepath = $this->log_path . 'log-' . date('Y-m-d') . '.log';
        if (!file_exists($filepath)) {
            $newfile = true;
        }

        if (!$fp = @fopen($filepath, 'ab')) {
            return false;
        }
        flock($fp, LOCK_EX);

        $message = $this->format_message($level, date($this->date_format), $message);

        for ($written = 0; $written < strlen($message); $written += $result) {
            if (($result = fwrite($fp, substr($message, $written))) === false) {
                break;
            }
        }
        flock($fp, LOCK_UN);
        fclose($fp);

        if (isset($newfile) && $newfile === TRUE) {
            chmod($filepath, $this->file_permissions);
        }

        return is_int($result);
    }
}