<?php

namespace DanielHe4rt\KickSDK\Events\Webhooks\Entities;

use JsonSerializable;

readonly class KickWebhookBadgeEntity implements JsonSerializable
{
    public function __construct(
        public string $text,
        public string $type,
        public ?int $count = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            text: $data['text'],
            type: $data['type'],
            count: $data['count'] ?? null,
        );
    }

    public function jsonSerialize(): array
    {
        $result = [
            'text' => $this->text,
            'type' => $this->type,
        ];

        if ($this->count !== null) {
            $result['count'] = $this->count;
        }

        return $result;
    }
}
