<?php

namespace Nigr\Chat;

use Exception;
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
     * @param $params
     * @return array
     * @throws Exception
     */
    public function chatGet($params): array
    {
        return $this->chatController->get($params);
    }

    /**
     * @param $params
     * @return array
     * @throws Exception
     */
    public function messageGet($params): array
    {
        return $this->messageController->get($params);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function messageCreate(): array
    {
        return $this->messageController->post();
    }
}
