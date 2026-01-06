<?php

namespace Nigr\Tests\Unit\Helpers;

use Nigr\Chat\Helpers\DataBase;
use PHPUnit\Framework\TestCase;

class DataBaseTest extends TestCase
{
	private static DataBase $dataBaseHelpers;

	public static function setUpBeforeClass(): void
	{
		parent::setUpBeforeClass();

		self::$dataBaseHelpers = new DataBase();
	}

	/**
	 * @param $queryParams
	 * @param $expected
	 * @return void
	 * @dataProvider getSelectQueryParams
	 */
	public function testGetSelectQueryStringFromQueryParams($queryParams, $expected): void
	{
		$result = self::$dataBaseHelpers->getQueryStringFromQueryParams($queryParams);

		$this->assertEquals($expected, $result);
	}

	public static function getSelectQueryParams(): array
	{
		return [
			[["id" => 3], "WHERE id=:id"],
			[["id" => 3, "name" => "Bob"], "WHERE id=:id AND name=:name"],
			[[], ""],
			[[""], ""],
			[["id"], ""],
			[[null], ""],
//			[null, ""]
		];
	}

	/**
	 * @param $queryParams
	 * @param $expected
	 * @return void
	 * @dataProvider getInsertQueryParams
	 */
	public function testGetInsertQueryStringFromQueryParams($queryParams, $expected): void
	{
		$result = self::$dataBaseHelpers->getQueryStringFromQueryParams($queryParams, "insert");

		$this->assertEquals($expected, $result);
	}

	public static function getInsertQueryParams(): array
	{
		return [
			[["id" => 3], "(id) values(:id)"],
			[["id" => 3, "age" => 25], "(id, age) values(:id, :age)"],
			[[], ""],
			[[""], ""],
			[["id"], ""],
			[[null], ""],
//			[null, ""]
		];
	}
}
