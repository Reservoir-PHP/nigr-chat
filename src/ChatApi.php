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
	 * @return string
	 * @throws Exception
	 */
	public function getChats(array $params): string
	{
		$result = $this->chatRepository->get($params);

		$data = array_map(fn(Chat $chat) => $chat->toArray(), $result);

		if (!empty($result)) {
			return $this->json(["status" => true, "code" => 200, "message" => "Chats found!", "data" => $data]);
		} else {
			return $this->json(["status" => false, "code" => 404, "message" => "Chats not found!", "data" => $result]);
		}
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	public function createChat(): string
	{
		$params = json_decode(file_get_contents("php://input"), true) ?? $_POST;

		$result = $this->chatRepository->post($params);
		$id = $result[0]->id;

		$data = array_map(fn(Chat $chat) => $chat->toArray(), $result);

		if (!empty($result)) {
			return $this->json(["status" => true, "code" => 201, "message" => "Chat $id created!", "data" => $data]);
		} else {
			return $this->json(["status" => false, "code" => 400, "message" => "Chat not created!", "data" => $result]);
		}
	}

	/**
	 * @param array $params
	 * @return string
	 * @throws Exception
	 */
	public function getMessages(array $params): string
	{
		$result = $this->messageRepository->get($params);

		$data = array_map(fn(Message $chat) => $chat->toArray(), $result);

		if (!empty($result)) {
			return $this->json(["status" => true, "code" => 200, "message" => "Messages found!", "data" => $data]);
		} else {
			return $this->json(["status" => false, "code" => 404, "message" => "Messages not found!", "data" => $result]);
		}
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	public function createMessage(): string
	{
		$params = json_decode(file_get_contents("php://input"), true) ?? $_POST;

		$result = $this->messageRepository->post($params);
		$id = $result[0]->id;

		$data = array_map(fn(Message $chat) => $chat->toArray(), $result);

		if (!empty($result)) {
			return $this->json(["status" => true, "code" => 201, "message" => "Message $id created!", "data" => $data]);
		} else {
			return $this->json(["status" => false, "code" => 400, "message" => "Message not created!", "data" => $result]);
		}
	}

	private function json(array $response): string
	{
		return json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
	}
}
