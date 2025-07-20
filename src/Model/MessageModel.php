<?php

namespace Nigr\Chat\Model;

class MessageModel extends Model
{
    protected string $type = 'messages';

    public function __construct($type = 'db')
    {
        parent::__construct($type);
    }
}
