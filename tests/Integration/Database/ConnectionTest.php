<?php

namespace Nigr\Tests\Integration\Database;

use Nigr\Chat\Database\Connection;
use PDO;
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{
	public function testGetConnection()
	{
		$dsn = "mysql:host=" . $_ENV["DB_HOST"] . ";dbname=" . $_ENV["DB_NAME"] . ";port=" . $_ENV["DB_PORT"] . ";charset=" . $_ENV["DB_CHARSET"];
		$username = $_ENV["DB_USERNAME"];
		$password = $_ENV["DB_PASSWORD"];

		$connection = new Connection($dsn, $username, $password);
		$pdo = $connection->getConnection();

		$this->assertInstanceOf(PDO::class, $pdo);
	}
}
