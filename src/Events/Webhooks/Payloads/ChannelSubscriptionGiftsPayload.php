<?php

namespace DanielHe4rt\KickSDK\Events\Webhooks\Payloads;

use DanielHe4rt\KickSDK\Events\Webhooks\Entities\KickWebhookUserEntity;
use DanielHe4rt\KickSDK\Events\Webhooks\Enums\KickWebhookEventTypeEnum;
use DateTimeImmutable;
use DateTimeInterface;

readonly class ChannelSubscriptionGiftsPayload extends KickWebhookPayload
{
    /**
     * @param  KickWebhookEventTypeEnum  $eventType  The type of event
     * @param  int  $eventVersion  The version of the event
     * @param  KickWebhookUserEntity  $broadcaster  The broadcaster information
     * @param  KickWebhookUserEntity  $gifter  The gifter information (may be anonymous)
     * @param  KickWebhookUserEntity[]  $giftees  Array of users who received the gift
     * @param  DateTimeImmutable  $createdAt  When the gifts were sent
     * @param  DateTimeImmutable|null  $expiresAt  When the gifted subscriptions expire
     */
    public function __construct(
        KickWebhookEventTypeEnum $eventType,
        int $eventVersion,
        KickWebhookUserEntity $broadcaster,
        public KickWebhookUserEntity $gifter,
        public array $giftees,
        public DateTimeInterface $createdAt,
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
        $gifter = KickWebhookUserEntity::fromArray($data['gifter']);

        $giftees = [];
        foreach ($data['giftees'] ?? [] as $gifteeData) {
            $giftees[] = KickWebhookUserEntity::fromArray($gifteeData);
        }

        $createdAt = new DateTimeImmutable($data['created_at']);
        $expiresAt = isset($data['expires_at']) ? new DateTimeImmutable($data['expires_at']) : null;

        return new self(
            eventType: $eventType,
            eventVersion: $eventVersion,
            broadcaster: $broadcaster,
            gifter: $gifter,
            giftees: $giftees,
            createdAt: $createdAt,
            expiresAt: $expiresAt,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'broadcaster' => $this->broadcaster->jsonSerialize(),
            'gifter' => $this->gifter->jsonSerialize(),
            'giftees' => array_map(fn (KickWebhookUserEntity $giftee) => $giftee->jsonSerialize(), $this->giftees),
            'created_at' => $this->createdAt->format('Y-m-d\TH:i:s\Z'),
            'expires_at' => $this->expiresAt?->format('Y-m-d\TH:i:s\Z'),
        ];
    }
}
