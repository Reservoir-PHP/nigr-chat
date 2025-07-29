<?php

namespace Nigr\Chat;

use Nigr\Chat\Controller\ChatController;
use Nigr\Chat\Controller\MessageController;

/**
 * @used-by Router
 * @noinspection PhpUnused
 */
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
     * @used-by Router
     * @noinspection PhpUnused
     * @param $params
     * @return array
     */
    public function chatGet($params): array
    {
        var_dump($params);
        die();
        return $this->chatController->get($params);
    }

    /**
     * @used-by Router
     * @noinspection PhpUnused
     * @param $params
     * @return array
     */
    public function messageGet($params): array
    {
        return $this->messageController->get($params);
    }

    /**
     * @used-by Router
     * @noinspection PhpUnused
     * @return array
     */
    public function messageCreate(): array
    {
        return $this->messageController->post();
    }
}
