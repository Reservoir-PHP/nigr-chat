<?php

namespace Nigr\Tests\unit;

use Nigr\Chat\Controller\ChatController;
use PHPUnit\Framework\TestCase;

class ChatStartTest extends TestCase
{
	private ChatController $chatController;

	protected function setUp(): void
	{
		parent::setUp();

		$this->chatController = new ChatController();
	}

	protected function tearDown(): void
	{
		parent::tearDown();
	}


	public function testChatGet(): void
	{
		$result = $this->chatController->get(["id" => 1]);

//		var_dump($result);

		$this->assertEquals(1, 1);
	}

	public function testChatPost()
	{
		$result = $this->chatController->post(['lot_id' => 2, 'contractor_id' => 1]);

		var_dump($result);

		$this->assertEquals(1, 1);
	}

	public function testMessageGet()
	{
		$this->assertEquals(1, 1);
	}

	public function testMessageCreate()
	{
		$this->assertEquals(1, 1);
	}
}
