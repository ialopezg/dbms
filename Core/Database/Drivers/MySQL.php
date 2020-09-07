<?php
require_once CORE_PATH . 'Database' . DS . 'DBException.php';

/**
 * DBMySQL Driver class.
 */
class DBMySQL implements IDatabase {
	/**
	 * @var PDO Connection object
	 */
	protected $connection;
	/**
	 * @var string Database name
	 */
	private $database;

	/**
	 * Connect to a database, according to params specified.
	 *
     * @param string $driver Database driver.
	 * @param string $hostname Database hostname.
	 * @param string $username Database username.
	 * @param string $password Database user password.
	 * @param string $database Database name.
	 *
	 * @throws DBException
	 */
	public function connect($driver = 'mysql', $hostname = '', $username = '', $password = '', $database = '') {
	    if (func_get_arg(0) && (is_object(func_get_arg(0)) || is_array(func_get_arg(0)))) {
	        $db = func_get_arg(0);
            $driver = strtolower((is_array($db) && isset($db['driver'])) ? $db['driver'] : ((is_object($db) && isset($db->driver)) ? $db->driver : $driver));
	        $hostname = (is_array($db) && isset($db['hostname'])) ? $db['hostname'] : ((is_object($db) && isset($db->hostname)) ? $db->hostname : $hostname);
            $username = (is_array($db) && isset($db['username'])) ? $db['username'] : ((is_object($db) && isset($db->username)) ? $db->username : $username);
            $password = (is_array($db) && isset($db['password']))? $db['password'] : ((is_object($db) && isset($db->password)) ? $db->password : $password);
            $database = (is_array($db) && isset($db['database'])) ? $db['database'] : ((is_object($db) && isset($db->database)) ? $db->database : $database);
            $charset = (is_array($db) && isset($db['charset'])) ? $db['charset'] : ((is_object($db) && isset($db->charset)) ? $db->charset : 'utf8');
        }

		try {
			$this->connection = new PDO("{$driver}:host={$hostname};dbname={$database}", $username, $password, [
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$charset}"
			]);
            $this->database = $db;
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			throw new DBException($e->getMessage(), (int)$e->getCode());
		}
	}

	/**
	 * Get all function names for current schema.
	 *
	 * @param string $prefix Function prefix.
	 *
	 * @return array An array with function names for current schema.
	 * @throws DBException
	 */
	public function getFunctions($prefix = '') {
        // TODO: Method to be implemented
	}

	/**
	 * Get all procedure names for current schema.
	 *
	 * @param string $prefix Procedure prefix.
	 *
	 * @return array An array with procedure names for current schema.
	 * @throws DBException
	 */
	public function getProcedures($prefix = '') {
        // TODO: Method to be implemented
	}

	/**
	 * Returns an array containing all the schema object names in the database.
	 *
	 * @example [tblArticles, vArticles, spAddArticle]
	 *
	 * @return array The schema object names in the database.
	 * @throws DBException
	 */
	public function getSchema() {
        // TODO: Method to be implemented
	}

	/**
	 * Given a schema object name, returns the SQL query that will create that schema object on any machine
	 * the DBMS of choice.
	 *
	 * @param string $name Object schema name.
	 *
	 * @return string The script for object creation.
	 * @throws DBException
	 */
	public function getSchemaObject($name) {
        // TODO: Method to be implemented
	}

	/**
	 * Get all table names for current schema.
	 *
	 * @param string $prefix Table prefix.
	 *
	 * @return array An array with table names for current schema.
	 * @throws DBException
	 */
	public function getTables($prefix = '') {
        // TODO: Method to be implemented
	}

	/**
	 * Get all trigger names for current schema.
	 *
	 * @param string $prefix Trigger prefix.
	 *
	 * @return array An array with trigger names for current schema.
	 * @throws DBException
	 */
	public function getTriggers($prefix = '') {
        // TODO: Method to be implemented
	}

	/**
	 * Get all view names for current schema.
	 *
	 * @param string $prefix View prefix.
	 *
	 * @return array An array with view names for current schema.
	 * @throws DBException
	 */
	public function getViews($prefix = '') {
        // TODO: Method to be implemented
	}

	/**
	 * Runs a SQL query.
	 *
	 * @param string $queryString Query string to be executed.
	 *
	 * @return false|PDOStatement Returns a PDOStatement object, or <b>FALSE</b> on failure.
	 * @throws DBException
	 */
	public function query($queryString) {
		// TODO: Method to be implemented
	}
}
