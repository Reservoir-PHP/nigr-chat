<?php

namespace Nigr\Chat\Models;

use DateTimeImmutable;
use Exception;

class Message
{
	public function __construct(
		public readonly int $id,
		public readonly int $chat_id,
		public readonly int $owner_id,
		public readonly string $text,
		public readonly ?int $recipient_id,
		public readonly ?DateTimeImmutable $created_at,
		public readonly ?DateTimeImmutable $updated_at
	) {
	}

	/**
	 * @param array $data
	 * @return static
	 * @throws Exception
	 */
	public static function fromArray(array $data): self
	{
		return new self(
			id: $data["id"],
			chat_id: $data["chat_id"],
			owner_id: $data["owner_id"],
			text: $data["text"],
			recipient_id: $data["recipient_id"],
			created_at: isset($data["created_at"]) ? new DateTimeImmutable($data["created_at"]) : null,
			updated_at: isset($data["updated_at"]) ? new DateTimeImmutable($data["updated_at"]) : null,
		);
	}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			"id" => $this->id,
			"chat_id" => $this->chat_id,
			"owner_id" => $this->owner_id,
			"text" => $this->text,
			"recipient_id" => $this->recipient_id,
			"created_at" => $this->created_at?->format('Y-m-d H:i:s'),
			"updated_at" => $this->updated_at?->format('Y-m-d H:i:s'),
		];
	}
}
