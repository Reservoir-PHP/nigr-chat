<?php

namespace Nigr\Tests\Unit;

use Exception;
use Nigr\Chat\ChatApi;
use Nigr\Chat\Database\Connection;
use Nigr\Chat\Models\Chat;
use Nigr\Chat\Models\Message;
use Nigr\Chat\Repositories\ChatRepository;
use Nigr\Chat\Repositories\MessageRepository;
use PHPUnit\Framework\TestCase;

use ReflectionProperty;

class ChatApiTest extends TestCase
{
	/**
	 * @param array $value
	 * @param array $expected
	 * @return void
	 * @throws Exception
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

		$result = json_decode($chatApi->getChats(["id" => 2]), true);

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
			[
				[new Chat(1, 2, 3, 4, null, null)],
				[
					"status" => true,
					"code" => 200,
					"message" => "Chats found!",
					"data" => [["id" => 1, "lot_id" => 2, "contractor_id" => 3, "executor_id" => 4, "created_at" => null, "updated_at" => null]]
				]
			],
			[
				[],
				["status" => false, "code" => 404, "message" => "Chats not found!", "data" => []]
			],
		];
	}

	/**
	 * @param array $value
	 * @param array $expected
	 * @return void
	 * @throws Exception
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

		$result = json_decode($chatApi->createChat(), true);

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
			[
				[new Chat(1, 2, 3, 4, null, null)],
				[
					"status" => true,
					"code" => 201,
					"message" => "Chat 1 created!",
					"data" => [["id" => 1, "lot_id" => 2, "contractor_id" => 3, "executor_id" => 4, "created_at" => null, "updated_at" => null]]
				]
			],
			[
				[],
				["status" => false, "code" => 400, "message" => "Chat not created!", "data" => []]
			],
		];
	}

	/**
	 * @param array $value
	 * @param array $expected
	 * @return void
	 * @throws Exception
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

		$result = json_decode($chatApi->getMessages([]), true);

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
			[
				[new Message(1, 2, 3, "Text", 4, null, null)],
				[
					"status" => true,
					"code" => 200,
					"message" => "Messages found!",
					"data" => [["id" => 1, "chat_id" => 2, "owner_id" => 3, "text" => "Text", "recipient_id" => 4, "created_at" => null, "updated_at" => null]]
				]
			],
			[[], ["status" => false, "code" => 404, "message" => "Messages not found!", "data" => []]],
		];
	}

	/**
	 * @param array $value
	 * @param array $expected
	 * @return void
	 * @throws Exception
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

		$result = json_decode($chatApi->createMessage(), true);

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
			[
				[new Message(1, 2, 3, "Text", 4, null, null)],
				[
					"status" => true,
					"code" => 201,
					"message" => "Message 1 created!",
					"data" => [["id" => 1, "chat_id" => 2, "owner_id" => 3, "text" => "Text", "recipient_id" => 4, "created_at" => null, "updated_at" => null]]
				]
			],
			[[], ["status" => false, "code" => 400, "message" => "Message not created!", "data" => []]],
		];
	}
}
