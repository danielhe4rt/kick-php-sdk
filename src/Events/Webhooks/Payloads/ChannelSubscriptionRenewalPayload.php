<?php

namespace DanielHe4rt\KickSDK\Events\Webhooks\Payloads;

use DanielHe4rt\KickSDK\Events\Webhooks\Entities\KickWebhookUserEntity;
use DanielHe4rt\KickSDK\Events\Webhooks\Enums\KickWebhookEventTypeEnum;
use DateTimeImmutable;

readonly class ChannelSubscriptionRenewalPayload extends KickWebhookPayload
{
    /**
     * @param  KickWebhookEventTypeEnum  $eventType  The type of event
     * @param  int  $eventVersion  The version of the event
     * @param  KickWebhookUserEntity  $broadcaster  The broadcaster information
     * @param  KickWebhookUserEntity  $subscriber  The subscriber information
     * @param  int  $duration  The subscription duration in months
     * @param  DateTimeImmutable  $createdAt  When the subscription was renewed
     * @param  DateTimeImmutable|null  $expiresAt  When the subscription expires
     */
    public function __construct(
        KickWebhookEventTypeEnum $eventType,
        int $eventVersion,
        KickWebhookUserEntity $broadcaster,
        public KickWebhookUserEntity $subscriber,
        public int $duration,
        public DateTimeImmutable $createdAt,
        public ?DateTimeImmutable $expiresAt = null,
    ) {
        parent::__construct($eventType, $eventVersion, $broadcaster);
    }

    /**
     * Create a webhook payload from an array
     *
     * @param  array  $data  The payload data
     * @param  KickWebhookEventTypeEnum  $eventType  The event type
     * @param  int  $eventVersion  The event version
     */
    public static function fromArray(array $data, KickWebhookEventTypeEnum $eventType, int $eventVersion): static
    {
        $broadcaster = KickWebhookUserEntity::fromArray($data['broadcaster']);
        $subscriber = KickWebhookUserEntity::fromArray($data['subscriber']);
        $createdAt = new DateTimeImmutable($data['created_at']);
        $expiresAt = isset($data['expires_at']) ? new DateTimeImmutable($data['expires_at']) : null;

        return new self(
            eventType: $eventType,
            eventVersion: $eventVersion,
            broadcaster: $broadcaster,
            subscriber: $subscriber,
            duration: $data['duration'],
            createdAt: $createdAt,
            expiresAt: $expiresAt,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'broadcaster' => $this->broadcaster->jsonSerialize(),
            'subscriber' => $this->subscriber->jsonSerialize(),
            'duration' => $this->duration,
            'created_at' => $this->createdAt->format('Y-m-d\TH:i:s\Z'),
            'expires_at' => $this->expiresAt?->format('Y-m-d\TH:i:s\Z'),
        ];
    }
}
