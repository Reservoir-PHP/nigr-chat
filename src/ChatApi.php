<?php

namespace Nigr\Chat;

use Nigr\Chat\Database\Connection;
use Nigr\Chat\Models\Chat;
use Nigr\Chat\Models\Message;
use Nigr\Chat\Repositories\ChatRepository;
use Nigr\Chat\Repositories\MessageRepository;

class ChatApi
{
	private Connection $db;
	private ChatRepository $chatRepository;
	private MessageRepository $messageRepository;

	public function __construct($dsn, $username, $password)
	{
		$this->db = new Connection($dsn, $username, $password);
		$this->chatRepository = new ChatRepository($this->db->getConnection());
		$this->messageRepository = new MessageRepository($this->db->getConnection());
	}

	/**
	 * @param array $params
	 * @return Chat[]
	 */
	public function readChats(array $params): array
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
	public function readMessages(array $params): array
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
