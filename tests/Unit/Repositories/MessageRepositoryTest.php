<?php

namespace Nigr\Tests\Unit\Repositories;

use Nigr\Chat\Helpers\DataBase;
use Nigr\Chat\Models\Message;
use Nigr\Chat\Repositories\MessageRepository;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class MessageRepositoryTest extends TestCase
{
	public function testGet($params = ["id" => 1], $expected = Message::class)
	{
		$pdoStatement = $this->getMockBuilder(PDOStatement::class)->disableOriginalConstructor()->getMock();
		$pdoStatement->method("execute")->willReturn(true);
		$pdoStatement->method("fetchAll")->willReturn(
			[
				[
					"id" => 1,
					"chat_id" => 2,
					"owner" => 3,
					"text" => "",
					"recipient" => 4,
					"created_at" => "",
					"updated_at" => ""
				]
			]
		);
		$pdo = $this->getMockBuilder(PDO::class)->disableOriginalConstructor()->getMock();
		$pdo->method("prepare")->willReturn($pdoStatement);
		$repository = new MessageRepository($pdo);

		$helpers = $this->getMockBuilder(DataBase::class)->disableOriginalConstructor()->getMock();
		$helpers->method("getQueryStringFromQueryParams")->willReturn("WHERE id=:id");
		$reflection = new ReflectionClass($repository);
		$reflection->getProperty("helpers")->setValue($repository, $helpers);

		$result = $repository->get($params);

		$this->assertInstanceOf($expected, $result[0]);
	}

	public function testPost($params = ["id" => 1, "chat_id" => 2, "owner" => 3, "text" => "", "recipient" => 4], $returnedId = 33, $expected = Message::class) {
		$pdoStatementMock = $this->getMockBuilder(PDOStatement::class)->disableOriginalConstructor()->getMock();
		$pdoStatementMock->method("execute")->willReturn(true);
		$pdoStatementMock->method("fetchAll")->willReturn(
			[
				[
					"id" => 1,
					"chat_id" => 2,
					"owner" => 3,
					"text" => "",
					"recipient" => 4,
					"created_at" => "",
					"updated_at" => ""
				]
			]
		);

		$pdoMock = $this->getMockBuilder(PDO::class)->disableOriginalConstructor()->getMock();
		$pdoMock->method("prepare")->willReturn($pdoStatementMock);
//		$pdoMock->method("lastInsertId")->willReturn($returnedId);

		$repository = new MessageRepository($pdoMock);

		$helpersMock = $this->getMockBuilder(DataBase::class)->disableOriginalConstructor()->getMock();
		$helpersMock->method("getQueryStringFromQueryParams")->willReturn("WHERE id=:id");
		$repoReflection = new ReflectionClass($repository);
		$repoReflection->getProperty("helpers")->setValue($repository, $helpersMock);

		$result = $repository->post($params);

		$this->assertInstanceOf($expected, $result[0]);
	}
}
