<?php

namespace Nigr\Chat\Controller;

use Exception;
use Nigr\Chat\Model\ChatModel;

class ChatController
{
    private ChatModel $chatModel;

    public function __construct()
    {
        $this->chatModel = new ChatModel();
    }

    /**
     * @param $params
     * @return array
     * @throws Exception
     */
    public function get($params): array
    {
        return $this->chatModel->get($params);
    }
}
