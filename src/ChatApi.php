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
	 * @return Chat[]
	 */
	public function getChats(array $params): array
	{
		return $this->chatRepository->get($params);
	}

	/**
	 * @return Chat[]
	 */
	public function createChat(): array
	{
		$params = json_decode(file_get_contents("php://input"), true) ?? $_POST;

		return $this->chatRepository->post($params);
	}

	/**
	 * @param array $params
	 * @return Message[]
	 */
	public function getMessages(array $params): array
	{
		return $this->messageRepository->get($params);
	}

	/**
	 * @return Message[]
	 */
	public function createMessage(): array
	{
		$params = json_decode(file_get_contents("php://input"), true) ?? $_POST;

		return $this->messageRepository->post($params);
	}
}
