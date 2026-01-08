## Get started

### Install library:

```bash
    composer require nigr/dotenv:@dev
```

### Get started:

1. Add routes;
2. Create DB connection: ChatApi::setConnection($dsn, $username, $password);
3. Call necessary method

### Using routes:

- 'GET' - "getChats"(get all chats or get defined chats by params),
- 'POST'- "createChat"(create chat),
- 'GET' - "getMessages"(get all messages or get defined messages by params),
- 'POST'- "createMessage"(create message)

### Prepare DB:

Chats:

- id: number
- lot_id: number
- contractor_id: number
- executor_id: number
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

## Data structure

- chat get = id?, lot_id?, contractor_id?, executor_id?
- chat post = lot_id, contractor_id, executor_id,
- message get = id?, chat_id?, owner?, text?, recipient?
- message post = chat_id, owner, text, recipient?

## Returned data(JSON)

- ["status" => true, "message" => "!", "data" => [];
- ["status" => false, "message" => "!", "data" => [];
