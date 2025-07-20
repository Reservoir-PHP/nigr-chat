<?php

namespace Nigr\Chat;

use Nigr\Chat\Controller\ChatController;
use Nigr\Chat\Controller\MessageController;

class ChatStart
{
    private ChatController $chatController;
    private MessageController $messageController;

    public function __construct()
    {
        $this->chatController = new ChatController();
        $this->messageController = new MessageController();
    }

    /**
     * @param $id
     * @return array
     */
    public function chatGet($id): array
    {
        return $this->chatController->get($id);
    }

    /**
     * @param $params
     * @return array
     */
    public function messageGet($params): array
    {
        return $this->messageController->get($params);
    }

    /**
     * @return array
     */
    public function messageCreate(): array
    {
        return $this->messageController->post();
    }
}
