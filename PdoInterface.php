<?php
/**
 * SugiPHP Database Abstraction Layer PDO Interface
 *
 * @package SugiPHP.DBAL
 * @author  Plamen Popov <tzappa@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php (MIT License)
 */

namespace DBAL;

use PDO;

interface PdoInterface
{
	/**
	 * Creates a PDO instance to represent a connection to the requested database.
	 *
	 * @param string $dsn
	 * @param string $username
	 * @param string $password
	 * @param array  $options
	 *
	 * @throws PDOException if the attempt to connect to the requested database fails.
	 */
	public function __construct($dsn, $username = "", $password = "", array $options = array());

	/**
	 * Set an attribute.
	 *
	 * @see http://php.net/manual/en/pdo.setattribute.php
	 *
	 * @param int $attribute
	 * @param mixed $value
	 *
	 * @return boolean TRUE on success or FALSE on failure.
	 */
	public function setAttribute($attribute, $value);

	/**
	 * Retrieve a database connection attribute.
	 *
	 * @param int $attribute
	 *
	 * @return mixed
	 */
	public function getAttribute($attribute);

	/**
	 * Fetch the SQLSTATE associated with the last operation on the database handle
	 *
	 * @return mixed Returns NULL if no operation has been run on the database handle.
	 */
	public function errorCode();

	/**
	 * Fetch extended error information associated with the last operation on the database handle.
	 *
	 * @return array
	 */
	public function errorInfo();

	/**
	 * Execute an SQL statement and return the number of affected rows.
	 *
	 * @param string $statement
	 *
	 * @return int|FALSE Returns the number of rows that were modified or deleted
	 * by the SQL statement you issued. If no rows were affected, exec() returns 0.
	 * boolean FALSE is returned if the statement fails.
	 */
	public function exec($statement);

	/**
	 * Executes an SQL statement, returning a result set as a PDOStatement object
	 *
	 * @param string $statement
	 *
	 * @return PDOStatement or FALSE on failure.
	 */
	public function query($statement);

	/**
	 * Prepares a statement for execution and returns a statement object.
	 *
	 * @param string $statement
	 * @param array $driver_options
	 *
	 * @return PDOStatement, FALSE or emits PDOException (depending on error handling).
	 */
	public function prepare($statement, $options = array());

	/**
	 * Returns the ID of the last inserted row or sequence value.
	 *
	 * @param string $name Name of the sequence object from which the ID should be returned
	 *
	 * @return string
	 */
	public function lastInsertId($name = null);

	/**
	 * Quotes a string for use in a query.
	 *
	 * @param string $string The string to be quoted.
	 * @param int $parameter_type Provides a data type hint for drivers that have alternate quoting styles.
	 *
	 * @return string
	 */
	public function quote($string, $parameter_type = self::PARAM_STR);

	/**
	 * Initiates a transaction.
	 *
	 * @return boolean TRUE on success or FALSE on failure.
	 */
	public function beginTransaction();

	/**
	 * Checks if inside a transaction.
	 *
	 * @return boolean TRUE if a transaction is currently active, and FALSE if not.
	 */
	public function inTransaction();

	/**
	 * Commits a transaction.
	 *
	 * @return boolean TRUE on success or FALSE on failure.
	 */
	public function commit();

	/**
	 * Rolls back a transaction
	 *
	 * @return boolean TRUE on success or FALSE on failure.
	 */
	public function rollBack();
}
