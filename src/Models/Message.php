<?php

namespace Nigr\Chat\Models;

class Message
{
	public function __construct(
		public readonly int $id,
		public readonly int $chat_id,
		public readonly int $owner_id,
		public readonly string $text,
		public readonly ?int $recipient_id,
		public readonly ?string $created_at,
		public readonly ?string $updated_at
	) {
	}
}
