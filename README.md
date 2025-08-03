## Get started

### Install library:
```bash
    composer require nigr/dotenv:@dev
```
### Add to the .env file, DSN-variables for connect to DB:
```.env
    'DB_HOST' => '',
    'DB_NAME' => '',
    'DB_PORT' => '',
    'DB_CHARSET' => '',
    'DB_USERNAME' => '',
    'DB_PASSWORD' => ''
```
### Add routes:
- 'chatGet'(get chat, if chat not exists, then create chat),
- 'messageGet'(get all messages or get defined messages by params),
- 'messageCreate'(create message)
For Example:
```php
    $router = new Router();
    $router->add("GET", "/chats", [\Nigr\Chat\ChatStart::class, 'chatGet']);
    $router->add("GET", "/messages", [\Nigr\Chat\ChatStart::class, 'messageGet']);
    $router->add("POST", "/messages", [\Nigr\Chat\ChatStart::class, 'messageCreate']);
```
### Prepare DB:
Messages:
- id: number AI
- chat_id: number
- owner: string
- recipient?: string
- text: string
- created_at: timestamp
- updated_at: timestamp
Chats:
- id: number
- lot_id: number
- contractor_id: number
- executor_id: number
- created_at: number
- updated_at: number