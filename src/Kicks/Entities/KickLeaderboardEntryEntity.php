<?php

namespace DanielHe4rt\KickSDK\Kicks\Entities;

use JsonSerializable;

readonly class KickLeaderboardEntryEntity implements JsonSerializable
{
    public function __construct(
        public int $rank,
        public int $userId,
        public string $username,
        public int $giftedAmount,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            rank: $data['rank'],
            userId: $data['user_id'],
            username: $data['username'],
            giftedAmount: $data['gifted_amount'],
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'rank' => $this->rank,
            'user_id' => $this->userId,
            'username' => $this->username,
            'gifted_amount' => $this->giftedAmount,
        ];
    }
}
