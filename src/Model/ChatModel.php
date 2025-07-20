<?php

namespace Nigr\Chat\Model;

class ChatModel extends Model
{
    protected string $type = 'chats';

    public function __construct($type = 'db')
    {
        parent::__construct($type);
    }
}
