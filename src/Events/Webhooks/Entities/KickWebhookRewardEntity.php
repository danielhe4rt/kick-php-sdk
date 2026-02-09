<?php

namespace DanielHe4rt\KickSDK\Events\Webhooks\Entities;

use JsonSerializable;

readonly class KickWebhookRewardEntity implements JsonSerializable
{
    public function __construct(
        public string $id,
        public string $title,
        public int $cost,
        public ?string $description,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            title: $data['title'],
            cost: $data['cost'],
            description: $data['description'] ?? null,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'cost' => $this->cost,
            'description' => $this->description,
        ];
    }
}
