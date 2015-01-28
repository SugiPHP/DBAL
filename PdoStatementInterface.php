<?php
/**
 * SugiPHP DBAL Statement
 *
 * @package SugiPHP.DBAL
 * @author  Plamen Popov <tzappa@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php (MIT License)
 */

namespace SugiPHP\DBAL;

use PDO;
use PDOStatement;

interface PdoStatementInterface
{
	/**
	 * Bind a column to a PHP variable.
	 *
	 * @param mixed $column
	 * @param mixed &$param
	 * @param integer $type
	 * @param integer $maxlen
	 * @param mixed $driverdata
	 *
	 * @return boolean TRUE on success or FALSE on failure.
	 */
	public function bindColumn($column, &$param, $type = null, $maxlen = null, $driverdata = null);

	/**
	 * Binds a parameter to the specified variable name.
	 *
	 * @see http://php.net/manual/en/pdostatement.bindparam.php
	 *
	 * @param mixed $parameter
	 * @param mixed &$variable
	 * @param integer $data_type
	 * @param integer $length
	 * @param mixed $driver_options
	 *
	 * @return boolean TRUE on success or FALSE on failure.
	 */
	public function bindParam($parameter, &$variable, $data_type = PDO::PARAM_STR, $length = null, $driver_options = null);

	/**
	 * Binds a value to a parameter.
	 *
	 * @see http://php.net/manual/en/pdostatement.bindvalue.php
	 *
	 * @param mixed $parameter
	 * @param mixed $value
	 * @param integer $data_type
	 *
	 * @return boolean TRUE on success or FALSE on failure.
	 */
	public function bindValue($parameter, $value, $data_type = PDO::PARAM_STR);

	/**
	 * Closes the cursor, enabling the statement to be executed again.
	 *
	 * @return boolean TRUE on success or FALSE on failure.
	 */
	public function closeCursor();

	/**
	 * Returns the number of columns in the result set.
	 *
	 * @return integer  Returns the number of columns in the result set
	 * represented by the PDOStatement object. If there is no result set, columnCount() returns 0.
	 */
	public function columnCount();

	/**
	 * Dump an SQL prepared command.
	 */
	public function debugDumpParams();

	/**
	 * Fetch the SQLSTATE associated with the last operation on the statement handle.
	 *
	 * @return string Identical to PDO::errorCode(), except that PDOStatement::errorCode()
	 * only retrieves error codes for operations performed with PDOStatement objects.
	 */
	public function errorCode();

	/**
	 * Fetch extended error information associated with the last operation on the statement handle.
	 *
	 * @return array of error information about the last operation performed by this statement handle.
	 */
	public function errorInfo();

	/**
	 * Executes a prepared statement.
	 *
	 * @param array $parameters Input parameters
	 *
	 * @return boolean TRUE on success or FALSE on failure.
	 */
	public function execute($parameters = null);
}
