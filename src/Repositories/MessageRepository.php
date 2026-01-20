<?php

namespace Nigr\Chat\Repositories;

use Exception;
use Nigr\Chat\Helpers\DataBase;
use Nigr\Chat\Models\Message;
use PDO;

class MessageRepository
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
	 * @return Message[]
	 * @throws Exception
	 */
	public function get(array $params): array
	{
		$rawRequest = $this->helpers->getQueryStringFromQueryParams($params);

		$statement = $this->pdo->prepare("SELECT * FROM messages $rawRequest");
		$statement->execute($params);
		$messages = $statement->fetchAll(PDO::FETCH_ASSOC);

		return array_map(fn(array $message) => Message::fromArray($message), $messages);
	}

	/**
	 * @param array $params
	 * @return Message[]
	 * @throws Exception
	 */
	public function post(array $params): array
	{
		$rawRequest = $this->helpers->getQueryStringFromQueryParams($params, "insert");

		$statement = $this->pdo->prepare("INSERT INTO messages $rawRequest");
		$statement->execute($params);
		$messageId = $this->pdo->lastInsertId();

		return $this->get(["id" => $messageId]);
	}
}
