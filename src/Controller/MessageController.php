<?php

namespace Nigr\Chat\Controller;

use Exception;
use Nigr\Chat\Model\MessageModel;

class MessageController
{
    private MessageModel $messageModel;

    public function __construct()
    {
        $this->messageModel = new MessageModel();
    }

    /**
     * @param $params
     * @return array
     * @throws Exception
     */
    public function get($params): array
    {
        return $this->messageModel->get($params);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function post(): array
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (count($data) === 0) return ['status' => false, 'message' => 'Data is empty!'];

        return $this->messageModel->post($data);
    }
}
