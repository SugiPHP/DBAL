<?php
/**
 * SugiPHP Database Abstraction Layer Connection
 *
 * @package SugiPHP.DBAL
 * @author  Plamen Popov <tzappa@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php (MIT License)
 */

namespace SugiPHP\DBAL;

use PDO;

class Connection extends PDO implements PdoInterface
{
	/**
	 * The Data Source Name.
	 *
	 * @var string
	 */
	protected $dsn;

	/**
	 * The user name for the DSN string. This parameter is optional for some PDO drivers.
	 *
	 * @var string
	 */
	protected $username;

	/**
	 * The password for the DSN string. This parameter is optional for some PDO drivers.
	 *
	 * @var string
	 */
	protected $password;

	/**
	 * A key=>value array of driver-specific connection options.
	 *
	 * @var array
	 */
	protected $options;

	/**
	 * A key=>value array of common and driver-specific attributes on the database handle.
	 *
	 * @var array
	 */
	protected $attributes = array(
		// Set error handling to Exception
		self::ATTR_ERRMODE            => self::ERRMODE_EXCEPTION,
		// Fetch return results as associative array
		self::ATTR_DEFAULT_FETCH_MODE => self::FETCH_ASSOC,
	);

	protected $pdo;
	protected $eventListener;

	/**
	 * Needed for establishing a lazy connection.
	 *
	 * @param string $dsn
	 * @param string $username
	 * @param string $password
	 * @param array $options
	 */
	public function __construct($dsn, $username = "", $password = "", array $options = array())
	{
		$this->dsn = $dsn;
		$this->username = $username;
		$this->password = $password;
		$this->options = $options;
	}

	/**
	 * Establishing connection with the database.
	 * After connecting to the database sets attributes.
	 *
	 * @throws PDOException if the attempt to connect to the requested database fails.
	 */
	public function connect()
	{
		if ($this->pdo) {
			return ;
		}

		$event = $this->startEvent(__FUNCTION__);
		// establish database connection
		parent::__construct($this->dsn, $this->username, $this->password, $this->options);
		$this->endEvent($event);

		$this->pdo = $this;

		foreach ($this->attributes as $attribute => $value) {
			parent::setAttribute($attribute, $value);
		}

		// Use custom PDOStatement to log/profile execute methods
		parent::setAttribute(PDO::ATTR_STATEMENT_CLASS, array("\\SugiPHP\\DBAL\\Statement", array($this)));
	}

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
	public function setAttribute($attribute, $value)
	{
		// If the connection is established set attribute right away
		if ($this->pdo) {
			return parent::setAttribute($attribute, $value);
		}

		// otherwise store it until connection is established
		$this->attributes[$attribute] = $value;

		// 100% success rate!
		return true;
	}

	/**
	 * Retrieve a database connection attribute.
	 *
	 * @param int $attribute
	 *
	 * @return mixed
	 */
	public function getAttribute($attribute)
	{
		// If the connection is not established
		// but we set the attribute already
		if (!$this->pdo && isset($this->attributes[$attribute])) {
			return $this->attributes[$attribute];
		}

		$this->connect();

		return parent::getAttribute($attribute);
	}

	/**
	 * Fetch the SQLSTATE associated with the last operation on the database handle
	 *
	 * @return mixed Returns NULL if no operation has been run on the database handle.
	 */
	public function errorCode()
	{
		$this->connect();

		return parent::errorCode();
	}

	/**
	 * Fetch extended error information associated with the last operation on the database handle.
	 *
	 * @return array
	 */
	public function errorInfo()
	{
		$this->connect();

		return parent::errorInfo();
	}

	/**
	 * Execute an SQL statement and return the number of affected rows.
	 *
	 * @param string $statement
	 *
	 * @return int|FALSE Returns the number of rows that were modified or deleted
	 * by the SQL statement you issued. If no rows were affected, exec() returns 0.
	 * boolean FALSE is returned if the statement fails.
	 */
	public function exec($statement)
	{
		$this->connect();

		$event = $this->startEvent(__FUNCTON__, $statement);
		$result = parent::exec($statement);
		$this->endEvent($event);

		return $result;
	}

	/**
	 * Executes an SQL statement, returning a result set as a PDOStatement object
	 * NOTE: The query() method can receive not only one, but 3 or 4 parameters.
	 *
	 * @see http://php.net/manual/en/pdo.query.php
	 *
	 * @param string $statement
	 *
	 * @return PDOStatement or FALSE on failure.
	 */
	public function query($statement)
	{
		$this->connect();

		$args = func_get_args();
		$argsCnt = count($args);

		$event = $this->startEvent(__FUNCTION__, $statement);
		if ($argsCnt == 2) {
			$result = parent::query($statement, $args[1]);
		} elseif ($argsCnt == 3) {
			$result = parent::query($statement, $args[1], $args[2]);
		} elseif ($argsCnt == 4) {
			$result = parent::query($statement, $args[1], $args[2], $args[3]);
		} else {
			$result = parent::query($statement);
		}
		$this->endEvent($event);

		return $result;
	}

	/**
	 * Prepares a statement for execution and returns a statement object.
	 *
	 * @param string $statement
	 * @param array $options Driver options
	 *
	 * @return PDOStatement, FALSE or emits PDOException (depending on error handling).
	 */
	public function prepare($statement, $options = array())
	{
		$this->connect();

		return parent::prepare($statement, $options);
	}

	/**
	 * Returns the ID of the last inserted row or sequence value.
	 *
	 * @param string $name Name of the sequence object from which the ID should be returned
	 *
	 * @return string
	 */
	public function lastInsertId($name = null)
	{
		$this->connect();

		return parent::lastInsertId($name);
	}

	/**
	 * Quotes a string for use in a query.
	 *
	 * @param string $string The string to be quoted.
	 * @param int $parameter_type Provides a data type hint for drivers that have alternate quoting styles.
	 *
	 * @return string
	 */
	public function quote($string, $parameter_type = PDO::PARAM_STR)
	{
		$this->connect();

		return parent::quote($string, $parameter_type);
	}

	/**
	 * Initiates a transaction.
	 *
	 * @return boolean TRUE on success or FALSE on failure.
	 */
	public function beginTransaction()

	{
		$this->connect();

		return parent::beginTransaction();
	}

	/**
	 * Checks if inside a transaction.
	 *
	 * @return boolean TRUE if a transaction is currently active, and FALSE if not.
	 */
	public function inTransaction()
	{
		$this->connect();

		return parent::inTransaction();
	}

	/**
	 * Commits a transaction.
	 *
	 * @return boolean TRUE on success or FALSE on failure.
	 */
	public function commit()
	{
		$this->connect();

		return parent::commit();
	}

	/**
	 * Rolls back a transaction
	 *
	 * @return boolean TRUE on success or FALSE on failure.
	 */
	public function rollBack()
	{
		$this->connect();

		return parent::rollBack();
	}

	public function setEventListener(callable $callable)
	{
		$this->eventListener = $callable;
	}

	public function startEvent($function, $statement = null)
	{
		if (!$this->eventListener) {
			return ;
		}

		$event = array(
			"function"  => $function,
			"statement" => $statement,
			"start"     => microtime(true),
		);

		return $event;
	}

	public function endEvent($event)
	{
		if ($event && $this->eventListener) {
			$event["end"] = microtime(true);
			$event["duration"] = $event["end"] - $event["start"];

			$func = $this->eventListener;
			$func($event);
		}

		return $event;
	}
}
