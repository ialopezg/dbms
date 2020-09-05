<?php

/**
 * IDatabase interface, blueprint for all Database classes.
 */
interface IDatabase {
	/**
	 * Connect to the database
	 *
	 * @param string $host
	 * @param string $username
	 * @param string $password
	 * @param string $dbname
	 *
	 * @return mixed
	 * @throws DBException
	 */
	public function connect($host = '', $username = '', $password = '', $dbname = '');

	/**
	 * Runs a SQL query.
	 *
	 * @param string $queryString Query string to be executed.
	 *
	 * @return false|PDOStatement Returns a PDOStatement object, or <b>FALSE</b> on failure.
	 * @throws DBException
	 */
	public function query($queryString);

	/**
	 * Returns an array containing all the schema object names in the database.
	 *
	 * @example [tblArticles, vArticles, spAddArticle]
	 *
	 * @return array The schema object names in the database.
	 * @throws DBException
	 */
	public function getSchema();

	/**
	 * Given a schema object name, returns the SQL query that will create that schema object on any machine
	 * the DBMS of choice.
	 *
	 * @param string $name Object schema name.
	 *
	 * @return string The script for object creation.
	 * @throws DBException
	 */
	public function getSchemaObject($name);
}
