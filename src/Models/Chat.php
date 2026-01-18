<?php

namespace Nigr\Chat\Models;

class Chat
{
	public function __construct(
		public readonly int $id,
		public readonly int $lot_id,
		public readonly int $contractor_id,
		public readonly int $executor_id,
		public readonly ?string $created_at,
		public readonly ?string $updated_at
	) {
	}
}
