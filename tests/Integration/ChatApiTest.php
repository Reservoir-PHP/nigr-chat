<?php

namespace Nigr\Tests\Integration;

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
	public function testConstructor()
	{
		$dsn = "mysql:host=" . $_ENV["DB_HOST"] . ";dbname=" . $_ENV["DB_NAME"] . ";port=" . $_ENV["DB_PORT"] . ";charset=" . $_ENV["DB_CHARSET"];
		$username = $_ENV["DB_USERNAME"];
		$password = $_ENV["DB_PASSWORD"];

		$chatApi = new ChatApi($dsn, $username, $password);
		$reflectionChatApi = new ReflectionClass($chatApi);

		$reflectionDb = $reflectionChatApi->getProperty("db");
		$reflectionChat = $reflectionChatApi->getProperty("chatRepository");
		$reflectionMessage = $reflectionChatApi->getProperty("messageRepository");

		$this->assertInstanceOf(Connection::class, $reflectionDb->getValue($chatApi));
		$this->assertInstanceOf(ChatRepository::class, $reflectionChat->getValue($chatApi));
		$this->assertInstanceOf(MessageRepository::class, $reflectionMessage->getValue($chatApi));
	}

	public function testReadChats($params = ["id" => 1])
	{
		$dsn = "mysql:host=" . $_ENV["DB_HOST"] . ";dbname=" . $_ENV["DB_NAME"] . ";port=" . $_ENV["DB_PORT"] . ";charset=" . $_ENV["DB_CHARSET"];
		$username = $_ENV["DB_USERNAME"];
		$password = $_ENV["DB_PASSWORD"];

		$chatApi = new ChatApi($dsn, $username, $password);

		$result = $chatApi->readChats($params);

		self::assertInstanceOf(Chat::class, $result[0]);
		self::assertEquals($params["id"], $result[0]->id);
	}

	public function testCreateChat($params = ["lot_id" => 2, "contractor_id" => 3, "executor_id" => 4])
	{
		$dsn = "mysql:host=" . $_ENV["DB_HOST"] . ";dbname=" . $_ENV["DB_NAME"] . ";port=" . $_ENV["DB_PORT"] . ";charset=" . $_ENV["DB_CHARSET"];
		$username = $_ENV["DB_USERNAME"];
		$password = $_ENV["DB_PASSWORD"];
		$_POST = $params;
		$chatApi = new ChatApi($dsn, $username, $password);

		$result = $chatApi->createChat();

		self::assertInstanceOf(Chat::class, $result[0]);
		self::assertEquals($params["lot_id"], $result[0]->lotId);
		self::assertEquals($params["contractor_id"], $result[0]->contractorId);
		self::assertEquals($params["executor_id"], $result[0]->executorId);
	}

	public function testReadMessages($params = ["id" => 1])
	{
		$dsn = "mysql:host=" . $_ENV["DB_HOST"] . ";dbname=" . $_ENV["DB_NAME"] . ";port=" . $_ENV["DB_PORT"] . ";charset=" . $_ENV["DB_CHARSET"];
		$username = $_ENV["DB_USERNAME"];
		$password = $_ENV["DB_PASSWORD"];

		$chatApi = new ChatApi($dsn, $username, $password);

		$result = $chatApi->readMessages($params);

		self::assertInstanceOf(Message::class, $result[0]);
		self::assertEquals($params["id"], $result[0]->id);
	}

	public function testCreateMessage($params = ["chat_id" => 2, "owner" => 3,"text" => "Text", "recipient" => 4])
	{
		$dsn = "mysql:host=" . $_ENV["DB_HOST"] . ";dbname=" . $_ENV["DB_NAME"] . ";port=" . $_ENV["DB_PORT"] . ";charset=" . $_ENV["DB_CHARSET"];
		$username = $_ENV["DB_USERNAME"];
		$password = $_ENV["DB_PASSWORD"];
		$_POST = $params;
		$chatApi = new ChatApi($dsn, $username, $password);

		$result = $chatApi->createMessage();

		self::assertInstanceOf(Message::class, $result[0]);
		self::assertEquals($params["chat_id"], $result[0]->chatId);
		self::assertEquals($params["owner"], $result[0]->ownerId);
		self::assertEquals($params["text"], $result[0]->text);
		self::assertEquals($params["recipient"], $result[0]->recipient);
	}
}
