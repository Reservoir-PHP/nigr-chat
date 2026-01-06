<?php

namespace Nigr\Chat\Models;

class Chat
{
	public function __construct(
		public readonly int $id,
		public readonly int $lotId,
		public readonly int $contractorId,
		public readonly int $executorId,
		public readonly ?string $createdAt,
		public readonly ?string $updatedAt
	) {
	}
}
