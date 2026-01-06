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

- 'GET'-"chatGet"(get chat, if chat not exists, then create chat),
- 'POST'-"chatPost"(get chat, if chat not exists, then create chat),
- 'GET'-"messageGet"(get all messages or get defined messages by params),
- 'POST'-"messageCreate"(create message)

### Prepare DB:

Chats:

- id: number
- lot_id: number
- contractor_id: number
- executor_id?: number
- created_at?: timestamp
- updated_at?: timestamp

Messages:

- id: number AI
- chat_id: number
- owner: string
- text: string
- recipient?: string
- created_at?: timestamp
- updated_at?: timestamp

## GET DATA

- chat get = id?, lot_id?, contractor_id?, executor_id?
- chat post = lot_id, contractor_id, executor_id
- message get = id?, chat_id?, owner?, text?, recipient?
- message post = chat_id, owner, text, recipient?

"WHERE chat_id=:chat_id"

## RETURN DATA

- ["status" => true, "message" => "!", "data" => [];
- ["status" => false, "message" => "!", "data" => [];

--------------------------------------------

### Literature

- Specification by Example
- Event storming
- Impact mapping

- ---

- Domain-Driven Design
- A SQRS
-

### Info

- фичакат(+) !== фичакрипт(-)
- impact mapping
- event storming
- UI-кит
- Корректная обработка ошибок
- by feature(+) !== by layer(-)
- Feature toggle

### ----

- Абстрактные классы тогда когда из него не будет никогда объекта, только у его потомков
- Интерфейсы никогда не имеют свойств и реализации методов, они нужны для контроля, что все необходимые методы будут реализованы в классах
- 
