<?php

namespace Nigr\Chat;

use Exception;
use Nigr\Chat\Database\Connection;
use Nigr\Chat\Models\Chat;
use Nigr\Chat\Models\Message;
use Nigr\Chat\Repositories\ChatRepository;
use Nigr\Chat\Repositories\MessageRepository;

class ChatApi
{
	private static ?Connection $db = null;
	private ChatRepository $chatRepository;
	private MessageRepository $messageRepository;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		if (self::$db === null) {
			throw new Exception("ChatApi::setConnection() must be called first");
		}

		$this->chatRepository = new ChatRepository(self::$db?->getConnection());
		$this->messageRepository = new MessageRepository(self::$db?->getConnection());
	}

	/**
	 * @param $dsn
	 * @param $username
	 * @param $password
	 * @return void
	 */
	public static function setConnection($dsn, $username, $password): void
	{
		self::$db = new Connection($dsn, $username, $password);
	}

	/**
	 * @param array $params
	 * @return array
	 */
	public function getChats(array $params): array
	{
		$result = $this->chatRepository->get($params);

		if (!empty($result)) {
			return ["status" => true, "code" => 200, "message" => "Chats found!", "data" => $result];
		} else {
			return ["status" => false, "code" => 404, "message" => "Chats not found!", "data" => $result];
		}
	}

	/**
	 * @return array
	 */
	public function createChat(): array
	{
		$params = json_decode(file_get_contents("php://input"), true) ?? $_POST;

		$result = $this->chatRepository->post($params);
		$id = $result[0]->id;

		if (!empty($result)) {
			return ["status" => true, "code" => 201, "message" => "Chat $id created!", "data" => $result];
		} else {
			return ["status" => false, "code" => 400, "message" => "Chat not created!", "data" => $result];
		}
	}

	/**
	 * @param array $params
	 * @return array
	 */
	public function getMessages(array $params): array
	{
		$result = $this->messageRepository->get($params);

		if (!empty($result)) {
			return ["status" => true, "code" => 200, "message" => "Messages found!", "data" => $result];
		} else {
			return ["status" => false, "code" => 404, "message" => "Messages not found!", "data" => $result];
		}
	}

	/**
	 * @return array
	 */
	public function createMessage(): array
	{
		$params = json_decode(file_get_contents("php://input"), true) ?? $_POST;

		$result = $this->messageRepository->post($params);
		$id = $result[0]->id;

		if (!empty($result)) {
			return ["status" => true, "code" => 201, "message" => "Message $id created!", "data" => $result];
		} else {
			return ["status" => false, "code" => 400, "message" => "Message not created!", "data" => $result];
		}
	}
}
