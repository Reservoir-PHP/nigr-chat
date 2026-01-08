<?php

namespace Nigr\Tests\Integration;

use Exception;
use Nigr\Chat\ChatApi;
use Nigr\Chat\Database\Connection;
use Nigr\Chat\Models\Chat;
use Nigr\Chat\Models\Message;
use Nigr\Chat\Repositories\ChatRepository;
use Nigr\Chat\Repositories\MessageRepository;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ChatApiTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();

		$dsn = "mysql:host=" . $_ENV["DB_HOST"] . ";dbname=" . $_ENV["DB_NAME"] . ";port=" . $_ENV["DB_PORT"] . ";charset=" . $_ENV["DB_CHARSET"];
		$username = $_ENV["DB_USERNAME"];
		$password = $_ENV["DB_PASSWORD"];

		ChatApi::setConnection($dsn, $username, $password);
	}

	protected function tearDown(): void
	{
		parent::tearDown();

		self::resetDb();
	}

	private static function resetDb(): void
	{
		$reflection = new ReflectionClass(ChatApi::class);
		$property = $reflection->getProperty('db');
		$property->setValue(null);
	}

	public function testConstructor()
	{
		$chatApi = new ChatApi();
		$reflectionChatApi = new ReflectionClass($chatApi);

		$reflectionDb = $reflectionChatApi->getProperty("db");
		$reflectionChat = $reflectionChatApi->getProperty("chatRepository");
		$reflectionMessage = $reflectionChatApi->getProperty("messageRepository");

		$this->assertInstanceOf(Connection::class, $reflectionDb->getValue($chatApi));
		$this->assertInstanceOf(ChatRepository::class, $reflectionChat->getValue($chatApi));
		$this->assertInstanceOf(MessageRepository::class, $reflectionMessage->getValue($chatApi));
	}

	public function testConstructorThrowsException()
	{
		self::resetDb();

		$this->expectException(Exception::class);

		new ChatApi();
	}

	public function testGetChats($params = ["id" => 1])
	{
		$chatApi = new ChatApi();

		$result = $chatApi->getChats($params)["data"];

		self::assertInstanceOf(Chat::class, $result[0]);
		self::assertEquals($params["id"], $result[0]->id);
	}

	public function testCreateChat($params = ["lot_id" => 2, "contractor_id" => 3, "executor_id" => 4])
	{
		$chatApi = new ChatApi();
		$_POST = $params;

		$result = $chatApi->createChat()["data"];

		self::assertInstanceOf(Chat::class, $result[0]);
		self::assertEquals($params["lot_id"], $result[0]->lotId);
		self::assertEquals($params["contractor_id"], $result[0]->contractorId);
		self::assertEquals($params["executor_id"], $result[0]->executorId);
	}

	public function testGetMessages($params = ["id" => 1])
	{
		$chatApi = new ChatApi();

		$result = $chatApi->getMessages($params)["data"];

		self::assertInstanceOf(Message::class, $result[0]);
		self::assertEquals($params["id"], $result[0]->id);
	}

	public function testCreateMessage($params = ["chat_id" => 2, "owner" => 3, "text" => "Text", "recipient" => 4])
	{
		$chatApi = new ChatApi();
		$_POST = $params;

		$result = $chatApi->createMessage()["data"];

		self::assertInstanceOf(Message::class, $result[0]);
		self::assertEquals($params["chat_id"], $result[0]->chatId);
		self::assertEquals($params["owner"], $result[0]->ownerId);
		self::assertEquals($params["text"], $result[0]->text);
		self::assertEquals($params["recipient"], $result[0]->recipient);
	}
}
