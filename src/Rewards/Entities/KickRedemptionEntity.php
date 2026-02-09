<?php

namespace DanielHe4rt\KickSDK\Rewards\Entities;

use JsonSerializable;

readonly class KickRedemptionEntity implements JsonSerializable
{
    public function __construct(
        public string $id,
        public string $rewardId,
        public int $userId,
        public string $username,
        public string $status,
        public ?string $userInput,
        public string $redeemedAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            rewardId: $data['reward_id'],
            userId: $data['user_id'],
            username: $data['username'],
            status: $data['status'],
            userInput: $data['user_input'] ?? null,
            redeemedAt: $data['redeemed_at'],
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'reward_id' => $this->rewardId,
            'user_id' => $this->userId,
            'username' => $this->username,
            'status' => $this->status,
            'user_input' => $this->userInput,
            'redeemed_at' => $this->redeemedAt,
        ];
    }
}
