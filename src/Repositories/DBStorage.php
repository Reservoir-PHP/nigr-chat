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
     * @param bool $fromPost
     * @return array|bool[]
     * @throws Exception
     */
    public function get(array $params, bool $fromPost = false): array
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

//        if (!reset($result) && array_key_exists('id', $params)) return [];
        if (count($result) === 0 && $this->table === "chats" && !$fromPost) return $this->post($params, true);
//        if (count($result) === 0 && $this->table === "messages") return [];
//        return count($result) > 1 ? $result : reset($result);
        return $result;
    }

    /**
     * @param array $data
     * @param bool $fromGet
     * @return array|bool[]
     * @throws Exception
     */
    public function post(array $data, bool $fromGet = false): array
    {
        if ($this->table === "users") {
            if (!array_key_exists('username', $data)) return ['status' => false, 'message' => 'Field username is required!'];
            if (!array_key_exists('password', $data)) return ['status' => false, 'message' => 'Field password is required!'];
            if (!array_key_exists('email', $data)) return ['status' => false, 'message' => 'Field email is required!'];
            if (!array_key_exists('type', $data)) return ['status' => false, 'message' => 'Field type is required!'];

            $params = ['email' => $data['email']];

            $existEntity = $this->get($params);

            if (count($existEntity) > 1) return ["status" => false, "message" => "Entity exists!"];

            $statement = $this->pdo->prepare("INSERT INTO users(username, password, email, type) values(:username, :password, :email, :type)");
        } else if ($this->table === "chats") {
            if (!array_key_exists('lot_id', $data)) return ['status' => false, 'message' => 'Field lot_id is required!'];
            if (!array_key_exists('contractor', $data)) return ['status' => false, 'message' => 'Field contractor is required!'];
            if (!array_key_exists('executor', $data)) return ['status' => false, 'message' => 'Field executor is required!'];
            if (!$fromGet && count($this->get($data, true)) > 0) return ['status' => false, 'message' => "Row exists!"];
            $statement = $this->pdo->prepare("INSERT INTO chats(lot_id, contractor, executor) values(:lot_id, :contractor, :executor)");
        } else if ($this->table === "messages") {
            if (!array_key_exists('chat_id', $data)) return ['status' => false, 'message' => 'Field chat_id is required!'];
            if (!array_key_exists('owner', $data)) return ['status' => false, 'message' => 'Field owner is required!'];
            if (!array_key_exists('recipient', $data)) return ['status' => false, 'message' => 'Field recipient is required!'];
            if (!array_key_exists('text', $data)) return ['status' => false, 'message' => 'Field text is required!'];

            $statement = $this->pdo->prepare("INSERT INTO messages(chat_id, owner, recipient, text) values(:chat_id, :owner, :recipient, :text)");
        } else {
            throw new Exception("Unknown table");
        }

        try {
            $statement->execute($data);

            return $this->get($data ?? []);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        return ["status" => true];
    }

    /**
     * @param array $queryParams
     * @return string
     */
    function getQueryStringFromQueryParams(array $queryParams): string
    {
        if ($queryParams === []) return '';

        $string = 'WHERE ';

        foreach ($queryParams as $key => $param) {
            $string .= "$key=:$key AND ";
        }

        return trim($string, "AND ");
    }
}
