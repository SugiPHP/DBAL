<?php
/**
 * SugiPHP Database Abstraction Layer Connection
 *
 * @package SugiPHP.DBAL
 * @author  Plamen Popov <tzappa@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php (MIT License)
 */

namespace DBAL;

use PDO;

class Connection extends PDO implements PdoInterface
{
	protected $pdo;

	protected $dsn;

	protected $username;

	protected $password;

	protected $options;

	/**
	 * Needed for establishing a lazy connection.
	 *
	 * @param string $dsn
	 * @param string $username
	 * @param string $password
	 * @param array  $options
	 */
	public function __construct($dsn, $username = "", $password = "", array $options = array())
	{
		$this->dsn = $dsn;
		$this->username = $username;
		$this->password = $password;
		$this->options = $options;
	}

	public function connect()
	{
		if (!$this->pdo) {
			parent::__construct($this->dsn, $this->username, $this->password, $this->options);

			$this->pdo = $this;
		}
	}

	public function setAttribute($attribute, $value)
	{
		$this->connect();

		return parent::setAttribute($attribute, $value);
	}

	public function getAttribute($attribute)
	{
		$this->connect();

		return parent::getAttribute($attribute);
	}

	public function errorCode()
	{
		$this->connect();

		return parent::errorCode();
	}

	public function errorInfo()
	{
		$this->connect();

		return parent::errorInfo();
	}

	public function exec($statement)
	{
		$this->connect();

		return parent::exec($statement);
	}

	public function query($statement)
	{
		$this->connect();

		return parent::query($statement);
	}

	public function prepare($statement, $options = array())
	{
		$this->connect();

		return parent::prepare($statement, $options);
	}

	public function lastInsertId($name = null)
	{
		$this->connect();

		return parent::prepare($statement, $options);
	}

	public function quote($string, $parameter_type = self::PARAM_STR)
	{
		$this->connect();

		return parent::quote($string, $parameter_type);
	}

	public function beginTransaction()
	{
		$this->connect();

		return parent::beginTransaction();
	}

	public function inTransaction()
	{
		$this->connect();

		return parent::inTransaction();
	}

	public function commit()
	{
		$this->connect();

		return parent::commit();
	}

	public function rollBack()
	{
		$this->connect();

		return parent::rollBack();
	}
}
