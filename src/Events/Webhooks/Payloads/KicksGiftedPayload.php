<?php

namespace DanielHe4rt\KickSDK\Events\Webhooks\Payloads;

use DanielHe4rt\KickSDK\Events\Webhooks\Entities\KickWebhookGiftEntity;
use DanielHe4rt\KickSDK\Events\Webhooks\Entities\KickWebhookUserEntity;
use DanielHe4rt\KickSDK\Events\Webhooks\Enums\KickWebhookEventTypeEnum;
use DateTimeImmutable;

readonly class KicksGiftedPayload extends KickWebhookPayload
{
    public function __construct(
        KickWebhookEventTypeEnum $eventType,
        int $eventVersion,
        KickWebhookUserEntity $broadcaster,
        public KickWebhookUserEntity $sender,
        public KickWebhookGiftEntity $gift,
        public DateTimeImmutable $createdAt,
    ) {
        parent::__construct($eventType, $eventVersion, $broadcaster);
    }

    public static function fromArray(array $data, KickWebhookEventTypeEnum $eventType, int $eventVersion): static
    {
        $broadcaster = KickWebhookUserEntity::fromArray($data['broadcaster']);
        $sender = KickWebhookUserEntity::fromArray($data['sender']);
        $gift = KickWebhookGiftEntity::fromArray($data['gift']);

        return new self(
            eventType: $eventType,
            eventVersion: $eventVersion,
            broadcaster: $broadcaster,
            sender: $sender,
            gift: $gift,
            createdAt: new DateTimeImmutable($data['created_at']),
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'broadcaster' => $this->broadcaster->jsonSerialize(),
            'sender' => $this->sender->jsonSerialize(),
            'gift' => $this->gift->jsonSerialize(),
            'created_at' => $this->createdAt->format('Y-m-d\TH:i:s\Z'),
        ];
    }
}
