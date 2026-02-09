<?php

namespace DanielHe4rt\KickSDK\Events\Webhooks\Entities;

use JsonSerializable;

readonly class KickWebhookGiftEntity implements JsonSerializable
{
    public function __construct(
        public int $amount,
        public string $name,
        public string $type,
        public string $tier,
        public ?string $message,
        public ?int $pinnedTimeSeconds,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            amount: $data['amount'],
            name: $data['name'],
            type: $data['type'],
            tier: $data['tier'],
            message: $data['message'] ?? null,
            pinnedTimeSeconds: $data['pinned_time_seconds'] ?? null,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->amount,
            'name' => $this->name,
            'type' => $this->type,
            'tier' => $this->tier,
            'message' => $this->message,
            'pinned_time_seconds' => $this->pinnedTimeSeconds,
        ];
    }
}
