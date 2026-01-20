<?php

namespace Nigr\Chat\Models;

use DateTimeImmutable;
use Exception;

class Chat
{
	public function __construct(
		public readonly int $id,
		public readonly int $lot_id,
		public readonly int $contractor_id,
		public readonly int $executor_id,
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
			lot_id: $data["lot_id"],
			contractor_id: $data["contractor_id"],
			executor_id: $data["executor_id"],
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
			"lot_id" => $this->lot_id,
			"contractor_id" => $this->contractor_id,
			"executor_id" => $this->executor_id,
			"created_at" => $this->created_at?->format('Y-m-d H:i:s'),
			"updated_at" => $this->updated_at?->format('Y-m-d H:i:s'),
		];
	}
}
