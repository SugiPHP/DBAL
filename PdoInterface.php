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
}
