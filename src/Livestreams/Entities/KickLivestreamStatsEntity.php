<?php

namespace DanielHe4rt\KickSDK\Livestreams\Entities;

use JsonSerializable;

readonly class KickLivestreamStatsEntity implements JsonSerializable
{
    public function __construct(
        public int $total,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            total: $data['total'],
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'total' => $this->total,
        ];
    }
}
