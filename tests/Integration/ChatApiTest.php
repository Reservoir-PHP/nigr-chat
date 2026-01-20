<?php

namespace Nigr\Tests\Integration;

use Exception;
use Nigr\Chat\ChatApi;
use Nigr\Chat\Database\Connection;
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

	/**
	 * @param array $params
	 * @return void
	 * @throws Exception
	 */
	public function testGetChats(array $params = ["id" => 1]): void
	{
		$chatApi = new ChatApi();

		$result = json_decode($chatApi->getChats($params), true)["data"];

		self::assertEquals($params["id"], $result[0]["id"]);
	}

	/**
	 * @param array $params
	 * @return void
	 * @throws Exception
	 */
	public function testCreateChat(array $params = ["lot_id" => 2, "contractor_id" => 3, "executor_id" => 4]): void
	{
		$chatApi = new ChatApi();
		$_POST = $params;

		$result = json_decode($chatApi->createChat(), true)["data"];

		self::assertEquals($params["lot_id"], $result[0]["lot_id"]);
		self::assertEquals($params["contractor_id"], $result[0]["contractor_id"]);
		self::assertEquals($params["executor_id"], $result[0]["executor_id"]);
	}

	/**
	 * @param array $params
	 * @return void
	 * @throws Exception
	 */
	public function testGetMessages(array $params = ["id" => 1]): void
	{
		$chatApi = new ChatApi();

		$result = json_decode($chatApi->getMessages($params), true)["data"];

		self::assertEquals($params["id"], $result[0]["id"]);
	}

	/**
	 * @param array $params
	 * @return void
	 * @throws Exception
	 */
	public function testCreateMessage(array $params = ["chat_id" => 2, "owner_id" => 3, "text" => "Text", "recipient_id" => 4]): void
	{
		$chatApi = new ChatApi();
		$_POST = $params;

		$result = json_decode($chatApi->createMessage(), true)["data"];

		self::assertEquals($params["chat_id"], $result[0]["chat_id"]);
		self::assertEquals($params["owner_id"], $result[0]["owner_id"]);
		self::assertEquals($params["text"], $result[0]["text"]);
		self::assertEquals($params["recipient_id"], $result[0]["recipient_id"]);
	}
}
