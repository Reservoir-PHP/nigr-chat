<?php

namespace Nigr\Chat\Repositories;

use Nigr\Chat\Helpers\DataBase;
use Nigr\Chat\Models\Chat;
use PDO;

class ChatRepository
{
	private DataBase $helpers;
	private PDO $pdo;

	public function __construct(PDO $pdo)
	{
		$this->helpers = new DataBase();
		$this->pdo = $pdo;
	}

	/**
	 * @param array $params
	 * @return Chat[]
	 */
	public function get(array $params): array
	{
		$rawRequest = $this->helpers->getQueryStringFromQueryParams($params);

		$statement = $this->pdo->prepare("SELECT * FROM chats $rawRequest");

		$statement->execute($params);
		$chats = $statement->fetchAll(PDO::FETCH_ASSOC);

		return array_map(fn($chat) => new Chat(
			(int)$chat['id'],
			(int)$chat['lot_id'],
			(int)$chat['contractor_id'],
			(int)$chat['executor_id'],
			(string)$chat['created_at'],
			(string)$chat['updated_at'],
		), $chats);
	}

	/**
	 * @param array $params
	 * @return Chat[]
	 */
	public function post(array $params): array
	{
		$rawRequest = $this->helpers->getQueryStringFromQueryParams($params, 'insert');

		$statement = $this->pdo->prepare("INSERT INTO chats $rawRequest");
		$statement->execute($params);
		$chatId = $this->pdo->lastInsertId();

		return $this->get(["id" => $chatId]);
	}
}
