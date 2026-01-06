<?php

namespace Nigr\Chat\Models;

class Message
{
	public function __construct(
		public readonly int $id,
		public readonly int $chatId,
		public readonly int $ownerId,
		public readonly string $text,
		public readonly ?int $recipient,
		public readonly ?string $createdAt,
		public readonly ?string $updatedAt
	) {
	}
}
