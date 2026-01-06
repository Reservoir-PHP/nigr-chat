<?php

namespace Nigr\Tests\Unit\Database;

use Exception;
use Nigr\Chat\Database\Connection;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ConnectionTest extends TestCase
{
	public function testConstructorSetsPropertiesCorrectly(): void
	{
		$dsn = "mysql:host=localhost;dbname=name;charset=utf8";
		$username = "user";
		$password = "pass";

		$connection = new Connection($dsn, $username, $password);
		$reflection = new ReflectionClass($connection);
		$dsnProperty = $reflection->getProperty("dsn");
		$usernameProperty = $reflection->getProperty("username");
		$passwordProperty = $reflection->getProperty("password");

		$this->assertEquals($dsn, $dsnProperty->getValue($connection));
		$this->assertEquals($username, $usernameProperty->getValue($connection));
		$this->assertEquals($password, $passwordProperty->getValue($connection));
	}

	public function testGetConnectionThrowsExceptionOnPDOFailure(): void
	{
		$connection = new Connection("invalid:dsn", "invalidUser", "invalidPass");

		$this->expectException(Exception::class);
		$this->expectExceptionMessageMatches("/Connection error:/");

		$connection->getConnection();
	}
}
