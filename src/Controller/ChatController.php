<?php

namespace Nigr\Chat\Controller;

use Nigr\Chat\Model\ChatModel;

class ChatController
{
    private ChatModel $chatModel;

    public function __construct()
    {
        $this->chatModel = new ChatModel();
    }

    public function get($params): array
    {
        return $this->chatModel->get($params);
    }

//    public function post(): array
//    {
//        return $this->chatModel->post($_POST);
//    }
}
