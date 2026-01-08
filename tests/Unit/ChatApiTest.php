<?php

namespace Nigr\Tests\Unit;

use Nigr\Chat\ChatApi;
use Nigr\Chat\Database\Connection;
use Nigr\Chat\Repositories\ChatRepository;
use Nigr\Chat\Repositories\MessageRepository;
use PHPUnit\Framework\TestCase;

use ReflectionProperty;

use function PHPUnit\Framework\assertIsArray;

class ChatApiTest extends TestCase
{
	/**
	 * @param array $value
	 * @param array $expected
	 * @return void
	 * @dataProvider getReturnedValueGetChats
	 */
	public function testGetChats(array $value, array $expected): void
	{
		$connectionMock = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
		$dbReflection = new ReflectionProperty(ChatApi::class, "db");
		$dbReflection->setValue(null, $connectionMock);

		$chatRepositoryMock = $this->getMockBuilder(ChatRepository::class)->disableOriginalConstructor()->getMock();
		$chatRepositoryMock->method("get")->willReturn($value);

		$chatApi = new ChatApi();

		$chatRepositoryReflection = new ReflectionProperty(ChatApi::class, "chatRepository");
		$chatRepositoryReflection->setValue($chatApi, $chatRepositoryMock);

		$result = $chatApi->getChats([]);

		self::assertIsArray($result);
		self::assertEquals($expected["status"], $result["status"]);
		self::assertEquals($expected["code"], $result["code"]);
		self::assertEquals($expected["message"], $result["message"]);
		self::assertIsArray($result["data"]);
		self::assertSame($expected["data"], $result["data"]);
	}

	public static function getReturnedValueGetChats(): array
	{
		return [
			[[["id" => 1]], ["status" => true, "code" => 200, "message" => "Chats found!", "data" => [["id" => 1]]]],
			[[], ["status" => false, "code" => 404, "message" => "Chats not found!", "data" => []]],
		];
	}

	/**
	 * @param array $value
	 * @param array $expected
	 * @return void
	 * @dataProvider getReturnedValueCreateChat
	 */
	public function testCreateChat(array $value, array $expected): void
	{
		$connectionMock = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
		$dbReflection = new ReflectionProperty(ChatApi::class, "db");
		$dbReflection->setValue(null, $connectionMock);

		$chatRepositoryMock = $this->getMockBuilder(ChatRepository::class)->disableOriginalConstructor()->getMock();
		$chatRepositoryMock->method("post")->willReturn($value);

		$chatApi = new ChatApi();

		$chatRepositoryReflection = new ReflectionProperty(ChatApi::class, "chatRepository");
		$chatRepositoryReflection->setValue($chatApi, $chatRepositoryMock);

		$result = $chatApi->createChat();

		self::assertIsArray($result);
		self::assertEquals($expected["status"], $result["status"]);
		self::assertEquals($expected["code"], $result["code"]);
		self::assertStringContainsString($expected["message"], $result["message"]);
		self::assertIsArray($result["data"]);
		self::assertSame($expected["data"], $result["data"]);
	}

	public static function getReturnedValueCreateChat(): array
	{
		return [
			[[["id" => 1]], ["status" => true, "code" => 201, "message" => "Chat", "data" => [["id" => 1]]]],
			[[], ["status" => false, "code" => 400, "message" => "Chat not created!", "data" => []]],
		];
	}

	/**
	 * @param array $value
	 * @param array $expected
	 * @return void
	 * @dataProvider getReturnedValueGetMessages
	 */
	public function testGetMessages(array $value, array $expected): void
	{
		$connectionMock = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
		$dbReflection = new ReflectionProperty(ChatApi::class, "db");
		$dbReflection->setValue(null, $connectionMock);

		$messageRepositoryMock = $this->getMockBuilder(MessageRepository::class)->disableOriginalConstructor()->getMock();
		$messageRepositoryMock->method("get")->willReturn($value);

		$chatApi = new ChatApi();

		$messageRepositoryReflection = new ReflectionProperty(ChatApi::class, "messageRepository");
		$messageRepositoryReflection->setValue($chatApi, $messageRepositoryMock);

		$result = $chatApi->getMessages([]);

		self::assertIsArray($result);
		self::assertEquals($expected["status"], $result["status"]);
		self::assertEquals($expected["code"], $result["code"]);
		self::assertStringContainsString($expected["message"], $result["message"]);
		self::assertIsArray($result["data"]);
		self::assertSame($expected["data"], $result["data"]);
	}

	public static function getReturnedValueGetMessages(): array
	{
		return [
			[[["id" => 1]], ["status" => true, "code" => 200, "message" => "Messages found!", "data" => [["id" => 1]]]],
			[[], ["status" => false, "code" => 404, "message" => "Messages not found!", "data" => []]],
		];
	}

	/**
	 * @param array $value
	 * @param array $expected
	 * @return void
	 * @dataProvider getReturnedValueCreateMessage
	 */
	public function testCreateMessage(array $value, array $expected): void
	{
		$connectionMock = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
		$dbReflection = new ReflectionProperty(ChatApi::class, "db");
		$dbReflection->setValue(null, $connectionMock);

		$messageRepositoryMock = $this->getMockBuilder(MessageRepository::class)->disableOriginalConstructor()->getMock();
		$messageRepositoryMock->method("post")->willReturn($value);

		$chatApi = new ChatApi();

		$messageRepositoryReflection = new ReflectionProperty(ChatApi::class, "messageRepository");
		$messageRepositoryReflection->setValue($chatApi, $messageRepositoryMock);

		$result = $chatApi->createMessage();

		self::assertIsArray($result);
		self::assertEquals($expected["status"], $result["status"]);
		self::assertEquals($expected["code"], $result["code"]);
		self::assertStringContainsString($expected["message"], $result["message"]);
		self::assertIsArray($result["data"]);
		self::assertSame($expected["data"], $result["data"]);
	}

	public static function getReturnedValueCreateMessage(): array
	{
		return [
			[[["id" => 1]], ["status" => true, "code" => 201, "message" => "Message", "data" => [["id" => 1]]]],
			[[], ["status" => false, "code" => 400, "message" => "Message not created!", "data" => []]],
		];
	}
}
