<?php

namespace Nigr\Tests\Unit;

use Nigr\Chat\ChatApi;
use Nigr\Chat\Database\Connection;
use Nigr\Chat\Repositories\ChatRepository;
use Nigr\Chat\Repositories\MessageRepository;
use PHPUnit\Framework\TestCase;

class ChatApiTest extends TestCase
{
//	private Connection $dbMock;
//	private ChatRepository $chatRepositoryMock;
//	private MessageRepository $messageRepositoryMock;
//
//	protected function setUp(): void
//	{
//		parent::setUp();
//
//		$this->dbMock = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
//		$this->chatRepositoryMock = $this->getMockBuilder(ChatRepository::class)->disableOriginalConstructor()->getMock();
//		$this->messageRepositoryMock = $this->getMockBuilder(MessageRepository::class)->disableOriginalConstructor()->getMock();
//	}

//	public function testConstructor()
//	{
//		$dsn = "mysql:host=localhost;dbname=name;charset=utf8";
//		$username = "user";
//		$password = "pass";
//
//		$chatApi = new ChatApi($dsn, $username, $password);
//		$reflectionChatApi = new ReflectionClass($chatApi);
//
//		$reflectionDb = $reflectionChatApi->getProperty('db');
//		$reflectionDb->setValue($reflectionChatApi, $this->dbMock);
//
//
//	}

//	public function testReadChats()
//	{
//	}
//
//	public function testCreateChat()
//	{
//	}
//
//	public function testReadMessages()
//	{
//	}
//
//	public function testCreateMessage()
//	{
//		$_POST = ["id" => 1];
//
//
//
//		$repositoryMock = $this->getMockBuilder(ChatRepository::class)->disableOriginalConstructor()->getMock();
//		$repositoryMock->method("post")->willReturn(
//			[
//				[
//					"id" => 1,
//					"chat_id" => 2,
//					"owner" => 3,
//					"text" => "",
//					"recipient" => 4,
//					"created_at" => "",
//					"updated_at" => ""
//				]
//			]
//		);
//
//		$chatApi = new ChatApi("mysql:host=", "", "");
//
//		$result = $chatApi->createMessage();
//
//		$this->assertInstanceOf(\Nigr\Chat\Models\Chat::class, $result[0]);
//	}
}
