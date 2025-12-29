<?php

namespace Nigr\Chat\Repositories;

use Exception;
use PDO;
use PDOException;

class DBStorage
{
	private PDO $pdo;
	private string $table;

	public function __construct(string $table)
	{
		$this->table = $table;

		try {
			$this->pdo = new PDO("mysql:host=" . $_ENV["DB_HOST"] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'] . ';charset=' . $_ENV['DB_CHARSET'],
				$_ENV['DB_USERNAME'],
				$_ENV['DB_PASSWORD']
			);
		} catch (PDOException $exception) {
			echo $exception->getMessage();
		}
	}

	/**
	 * @param array $params
	 * @return array
	 * @throws Exception
	 */
	public function get(array $params): array
	{
		if (array_key_exists('id', $params)) $params = ['id' => $params['id']];

		$queryString = $this->getQueryStringFromQueryParams($params);

		$statement = $this->pdo->prepare("SELECT * FROM $this->table $queryString");

		try {
			$statement->execute($params);
		} catch (PDOException $exception) {
			echo $exception->getMessage();
		}

		$result = $statement->fetchAll(PDO::FETCH_ASSOC);

		if (!$result || count($result) === 0) return ["status" => false, "message" => "Not found!", "data" => []];

		return ["status" => true, "message" => "Request done!", "data" => $result];
	}

	/**
	 * @param array $data
	 * @return array|bool[]
	 * @throws Exception
	 */
	public function post(array $data): array
	{
		$queryString = $this->getQueryStringFromQueryParams($data, "insert");

		if ($this->table === "chats") {
			if (!array_key_exists('lot_id', $data)) return ['status' => false, 'message' => 'Field lot_id is required!'];
			if (!array_key_exists('contractor_id', $data)) return ['status' => false, 'message' => 'Field contractor is required!'];
			if (count($this->get($data)["data"]) > 0) return ['status' => false, 'message' => "Row exists!"];

			$statement = $this->pdo->prepare("INSERT INTO chats $queryString");
		} else if ($this->table === "messages") {
			if (!array_key_exists('chat_id', $data)) return ['status' => false, 'message' => 'Field chat_id is required!'];
			if (!array_key_exists('owner', $data)) return ['status' => false, 'message' => 'Field owner is required!'];
			if (!array_key_exists('text', $data)) return ['status' => false, 'message' => 'Field text is required!'];

			$statement = $this->pdo->prepare("INSERT INTO messages $queryString");
		} else {
			throw new Exception("Unknown table");
		}

		try {
			$statement->execute($data);
		} catch (PDOException $e) {
			echo $e->getMessage();
			return ["status" => false, "message" => $e->getMessage(), "data" => []];
		}
		$result = $this->get($data);

		return ["status" => true, "message" => "Created!", "data" => $result["data"]];
	}

	/**
	 * @param array $queryParams
	 * @param string $key
	 * @return string
	 */
	function getQueryStringFromQueryParams(array $queryParams, string $key = 'select'): string
	{
		$queryString = '';

		if ($queryParams === []) return $queryString;

		if ($key === "insert") {
			$column = "";
			$values = "";

			foreach ($queryParams as $key => $param) {
				$column .= "$key, ";
				$values .= ":$key, ";
			}

			$column = trim($column, ", ");
			$values = trim($values, ", ");

			$queryString = "($column) values($values)";

		} else {
			$queryString = 'WHERE ';

			foreach ($queryParams as $key => $param) {
				$queryString .= "$key=:$key AND ";
			}

			$queryString = trim($queryString, "AND ");
		}

		return $queryString;
	}
}
