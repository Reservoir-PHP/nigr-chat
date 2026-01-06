<?php

namespace Nigr\Chat\Database;

use Exception;
use PDO;
use PDOException;

class Connection
{
	private string $dsn;
	private string $username;
	private string $password;

	public function __construct($dsn, $username, $password)
	{
		$this->dsn = $dsn;
		$this->username = $username;
		$this->password = $password;
	}

	/**
	 * @return PDO
	 * @throws Exception
	 */
	public function getConnection(): PDO
	{
		try {
			return new PDO($this->dsn, $this->username, $this->password);
		} catch (PDOException $e) {
			throw new Exception("Connection error: " . $e->getMessage());
		}
	}
}
