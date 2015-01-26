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
			$this->pdo = parent::__construct($this->dsn, $this->username, $this->password, $this->options);
		}
	}

	public function setAttribute($attribute, $value)
	{
		$this->connect();

		return parent::setAttribute($attribute, $value);
	}
}
