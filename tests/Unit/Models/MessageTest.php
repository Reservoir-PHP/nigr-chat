<?php

namespace Nigr\Tests\Unit\Models;

use ArgumentCountError;
use Nigr\Chat\Models\Message;
use PHPUnit\Framework\TestCase;
use TypeError;

class MessageTest extends TestCase
{

	/**
	 * @param array $args
	 * @param $expected
	 * @return void
	 * @dataProvider getChatArguments
	 */
	public function testConstructor(array $args, $expected): void
	{
		$chat = new Message(...$args);

		$this->assertEquals($expected[0], $chat->id);
		$this->assertEquals($expected[1], $chat->chatId);
		$this->assertEquals($expected[2], $chat->ownerId);
		$this->assertEquals($expected[3], $chat->text);
		$this->assertEquals($expected[4], $chat->recipient);
		$this->assertEquals($expected[5], $chat->createdAt);
		$this->assertEquals($expected[6], $chat->updatedAt);
	}

	public static function getChatArguments(): array
	{
		return [
			[[1, 2, 3, "text", 4, "", ""], [1, 2, 3, "text", 4, "", ""]],
			[["1", 2, "3", "text", "4", 999, "999"], [1, 2, 3, "text", 4, "999", "999"]],
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
		$chat = new Message(...$args);
	}

	public static function getArgumentsForTypeError(): array
	{
		return [
			[["test", 2, 3, "text", 4, "", ""]],
			[[1, "test", 3, "text", 4, "", ""]],
			[[1, 2, "test", "text", 4, "", ""]],
			[[1, 2, 3, null, 4, "", ""]],
			[[1, 2, 3, "text", "test", "", ""]],
			[[1, 2, 3, "text", 4, [], ""]],
			[[1, 2, 3, "text", 4, "", []]],
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
		$chat = new Message(...$args);
	}

	public static function getArgumentsForCountError(): array
	{
		return [
			[[1, 2, 3, "text", 4, ""]],
		];
	}
}
