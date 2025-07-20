## Get started

### Install library:
```bash
    composer require nigr/dotenv:@dev
```
### Add to the .env file, variable 'dsn' for connect to DB:
```php
    $_ENV['dsn'] = [
        'host' => '',
        'dbname' => '',
        'port' => '',
        'charset' => '',
        'username' => '',
        'password' => ''
    ];
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
- executor: string