<?php

namespace DanielHe4rt\KickSDK\Events\Webhooks\Entities;

use DateTimeImmutable;
use JsonSerializable;

readonly class KickWebhookBanMetadataEntity implements JsonSerializable
{
    public function __construct(
        public ?string $reason,
        public DateTimeImmutable $createdAt,
        public ?DateTimeImmutable $expiresAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            reason: $data['reason'] ?? null,
            createdAt: new DateTimeImmutable($data['created_at']),
            expiresAt: isset($data['expires_at']) ? new DateTimeImmutable($data['expires_at']) : null,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'reason' => $this->reason,
            'created_at' => $this->createdAt->format('Y-m-d\TH:i:s\Z'),
            'expires_at' => $this->expiresAt?->format('Y-m-d\TH:i:s\Z'),
        ];
    }
}
