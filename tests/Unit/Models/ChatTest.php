<?php

namespace Nigr\Tests\Unit\Models;

use ArgumentCountError;
use Nigr\Chat\Models\Chat;
use PHPUnit\Framework\TestCase;
use TypeError;

class ChatTest extends TestCase
{

	/**
	 * @param array $args
	 * @param $expected
	 * @return void
	 * @dataProvider getChatArguments
	 */
	public function testConstructor(array $args, $expected): void
	{
		$chat = new Chat(...$args);

		$this->assertEquals($expected[0], $chat->id);
		$this->assertEquals($expected[1], $chat->lotId);
		$this->assertEquals($expected[2], $chat->contractorId);
		$this->assertEquals($expected[3], $chat->executorId);
		$this->assertEquals($expected[4], $chat->createdAt);
		$this->assertEquals($expected[5], $chat->updatedAt);
	}

	public static function getChatArguments(): array
	{
		return [
			[[1, 2, 3, 4, "", ""], [1, 2, 3, 4, "", ""]],
			[["1", "2", "3", 4, 999, "999"], [1, 2, 3, 4, "999", "999"]],
		];
	}

	/**
	 * @param array $args
	 * @return void
	 * @dataProvider getArgumentsForTypeError
	 */
	public function testTypeError(array $args): void
	{
		$this->expectException(TypeError::class);

		/** @noinspection PhpUnusedLocalVariableInspection */
		$chat = new Chat(...$args);
	}

	public static function getArgumentsForTypeError(): array
	{
		return [
			[["name", 2, 3, 4, "", ""]],
			[[1, "age", 3, 4, "", ""]],
			[[1, 2, "id", 4, "", ""]],
			[[1, 2, 3, "test", "", ""]],
			[[1, 2, 3, "test", null, ""]],
			[[1, 2, 3, "test", null, true]],
		];
	}

	/**
	 * @param array $args
	 * @return void
	 * @dataProvider getArgumentsForCountError
	 */
	public function testArgumentCountError(array $args): void
	{
		$this->expectException(ArgumentCountError::class);

		/** @noinspection PhpUnusedLocalVariableInspection */
		$chat = new Chat(...$args);
	}

	public static function getArgumentsForCountError(): array
	{
		return [
			[[1, 2, 3, 4, ""]],
		];
	}
}
