<?php

namespace Nigr\Chat\Model;

use Nigr\Chat\Core\DBStorage;
use Nigr\Chat\Core\FileStorage;

class Model
{
    protected string $type = "";
    protected DBStorage|FileStorage $storage;

    public function __construct($type = 'db')
    {
        if ($type === 'db') {
            $this->storage = new DBStorage($this->type);
        } else {
            $this->storage = new FileStorage($this->type);
        }
    }

    /**
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function get($data): array
    {
        return $this->storage->get($data);
    }

    /**
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function post($data): array
    {
        return $this->storage->post($data);
    }
}
