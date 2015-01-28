<?php
/**
 * SugiPHP DBAL Statement
 *
 * @package SugiPHP.DBAL
 * @author  Plamen Popov <tzappa@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php (MIT License)
 */

namespace SugiPHP\DBAL;

use PDOStatement;

class Statement extends PDOStatement implements PdoStatementInterface
{
	protected $connection;

	protected function __construct($connection)
	{
		$this->connection = $connection;
	}

	/**
	 * Executes a prepared statement.
	 *
	 * @param array $parameters Input parameters
	 *
	 * @return boolean TRUE on success or FALSE on failure.
	 */
	public function execute($parameters = null)
	{
		$event = $this->connection->startEvent(__FUNCTION__, $this->queryString);

		$result = parent::execute($parameters);

		$this->connection->endEvent($event);

		return $result;
	}
}
