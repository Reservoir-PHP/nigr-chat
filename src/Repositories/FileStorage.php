<?php

namespace Nigr\Chat\Repositories;

use Exception;

const CHATS_DIR_STORAGE = '.\data\chats';
const CHATS_FILE_STORAGE = 'storage.json';

class FileStorage
{
    private string $dirPath;
    private string $filePath;
    private string $nameStorage;
    private array $data;

    public function __construct($nameStorage)
    {
        $this->nameStorage = $nameStorage;
        $this->dirPath = CHATS_DIR_STORAGE . '\\' . $nameStorage;
        $this->filePath = $this->dirPath . "\\" . $nameStorage . '_' . CHATS_FILE_STORAGE;

        if (!$this->checkStorageExists()) $this->createStorage();

        $this->data = $this->getDataFromFile();
    }

    /**
     * @param array $params
     * @param bool $fromPost
     * @return array
     * @throws Exception
     */
    public function get(array $params, bool $fromPost = false): array
    {
        if (array_key_exists("chat_id", $params)) $params['chat_id'] = intval($params['chat_id']);
        if (count($params) === 0) return $this->data;

        $result = $this->getElementsFromArray($this->data, $params);

        if ($this->nameStorage === "messages") return $result;
        if (count($result) === 0 && $this->nameStorage === "chats" && !$fromPost) return $this->post($params, true);

        return reset($result) ?: [];
    }

    /**
     * @param array $data
     * @param bool $fromGet
     * @return array
     * @throws Exception
     */
    public function post(array $data, bool $fromGet = false): array
    {
        $data['created_at'] = time();
        $data['updated_at'] = time();

        if ($this->nameStorage === "users") {
            if (!array_key_exists('username', $data)) return ['status' => false, 'message' => 'Field username is required!'];
            if (!array_key_exists('password', $data)) return ['status' => false, 'message' => 'Field password is required!'];
            if (!array_key_exists('email', $data)) return ['status' => false, 'message' => 'Field email is required!'];
            if (!array_key_exists('type', $data)) return ['status' => false, 'message' => 'Field type is required!'];

            $params = [
                'email' => $data['email']
            ];

            $existEntity = $this->get($params);

            if (count($existEntity) > 1) return ["status" => false, "message" => "Entity exists!"];
        } elseif ($this->nameStorage === "chats") {
            if (!array_key_exists('lot_id', $data)) return ['status' => false, 'message' => 'Field lot_id is required!'];
            if (!array_key_exists('executor', $data)) return ['status' => false, 'message' => 'Field executor is required!'];
            if (!$fromGet && count($this->get($data, true)) > 0) return ['status' => false, 'message' => "Row exists!"];
        } elseif ($this->nameStorage === "messages") {
            if (!array_key_exists('chat_id', $data)) return ['status' => false, 'message' => 'Field chat_id is required!'];
            if (!array_key_exists('owner', $data)) return ['status' => false, 'message' => 'Field owner is required!'];
            if (!array_key_exists('recipient', $data)) return ['status' => false, 'message' => 'Field recipient is required!'];
            if (!array_key_exists('text', $data)) return ['status' => false, 'message' => 'Field text is required!'];
        } else {
            throw new Exception("Unknown table");
        }

        $newId = $this->maxId($this->data) + 1;
        $data['id'] = $newId;
        $this->data[] = $data;

        return $this->get(['id' => $newId]);
    }

    public function __destruct()
    {
        file_put_contents($this->filePath, json_encode($this->data));
    }

    /**
     * @return bool
     */
    private function checkStorageExists(): bool
    {
        return file_exists($this->filePath);
    }

    /**
     * @return void
     */
    private function createStorage(): void
    {
        mkdir($this->dirPath, 0777, true);

        file_put_contents($this->filePath, '[]');
    }

    /**
     * @return array
     */
    private function getDataFromFile(): array
    {
        $json = file_get_contents($this->filePath);

        return json_decode($json, true);
    }

    /**
     * @param array $array
     * @param array $params
     * @return array
     */
    private function getElementsFromArray(array $array, array $params): array
    {
        foreach ($params as $key => $value) {
            if ($key === 'id' || $key === 'chatId') $value = (int)$value;

            $array = array_filter($array, function ($item) use ($key, $value) {
                return $item[$key] === $value;
            });
        }

        return array_values($array);
    }

    /**
     * @param $array
     * @return int
     */
    private function maxId($array): int
    {
        return array_reduce($array, function ($acc, $item) {
            return ($acc < $item['id']) ? $item['id'] : $acc;
        }, 1);
    }
}
