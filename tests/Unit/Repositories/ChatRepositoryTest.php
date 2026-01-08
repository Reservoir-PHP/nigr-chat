<?php

namespace Nigr\Tests\Unit\Repositories;

use Nigr\Chat\Helpers\DataBase;
use Nigr\Chat\Models\Chat;
use Nigr\Chat\Repositories\ChatRepository;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ChatRepositoryTest extends TestCase
{
	public function testGet($params = ["id" => 1], $expected = Chat::class)
	{
		$pdoStatementMock = $this->getMockBuilder(PDOStatement::class)->disableOriginalConstructor()->getMock();
		$pdoStatementMock->method("execute")->willReturn(true);
		$pdoStatementMock->method("fetchAll")->willReturn(
			[
				[
					"id" => 1,
					"lot_id" => 2,
					"contractor_id" => 3,
					"executor_id" => 4,
					"created_at" => "",
					"updated_at" => ""
				]
			]
		);

		$pdoMock = $this->getMockBuilder(PDO::class)->disableOriginalConstructor()->getMock();
		$pdoMock->method("prepare")->willReturn($pdoStatementMock);

		$repository = new ChatRepository($pdoMock);

		$map = [
			[["id" => 1], "select", "WHERE id=:id"],
			[["lot_id" => 2], "select", "WHERE lot_id=:lot_id"],
		];

		$helpersMock = $this->getMockBuilder(DataBase::class)->disableOriginalConstructor()->getMock();
		$helpersMock->method("getQueryStringFromQueryParams")->willReturnMap($map);
		$repoReflection = new ReflectionClass($repository);
		$repoReflection->getProperty("helpers")->setValue($repository, $helpersMock);

		$this->assertInstanceOf($expected, $repository->get($params)[0]);
	}

	public function testPost($params = ["id" => 1, "lot_id" => 2, "contractor_id" => 3, "executor_id" => 4], $returnedId = 33, $expected = Chat::class)
	{
		$pdoStatementMock = $this->getMockBuilder(PDOStatement::class)->disableOriginalConstructor()->getMock();
		$pdoStatementMock->method("execute")->willReturn(true);
		$pdoStatementMock->method("fetchAll")->willReturn(
			[
				[
					"id" => 1,
					"lot_id" => 2,
					"contractor_id" => 3,
					"executor_id" => 4,
					"created_at" => "",
					"updated_at" => ""
				]
			]
		);

		$pdoMock = $this->getMockBuilder(PDO::class)->disableOriginalConstructor()->getMock();
		$pdoMock->method("prepare")->willReturn($pdoStatementMock);

		$repository = new ChatRepository($pdoMock);

		$helpersMock = $this->getMockBuilder(DataBase::class)->disableOriginalConstructor()->getMock();
		$helpersMock->method("getQueryStringFromQueryParams")->willReturn("WHERE id=:id");
		$repoReflection = new ReflectionClass($repository);
		$repoReflection->getProperty("helpers")->setValue($repository, $helpersMock);

		$result = $repository->post($params);

		$this->assertInstanceOf($expected, $result[0]);
	}
}
