<?php

namespace DanielHe4rt\KickSDK\Events\Webhooks\Payloads;

use DanielHe4rt\KickSDK\Events\Webhooks\Entities\KickWebhookRewardEntity;
use DanielHe4rt\KickSDK\Events\Webhooks\Entities\KickWebhookUserEntity;
use DanielHe4rt\KickSDK\Events\Webhooks\Enums\KickWebhookEventTypeEnum;
use DateTimeImmutable;

readonly class ChannelRewardRedemptionUpdatedPayload extends KickWebhookPayload
{
    public function __construct(
        KickWebhookEventTypeEnum $eventType,
        int $eventVersion,
        KickWebhookUserEntity $broadcaster,
        public string $id,
        public ?string $userInput,
        public string $status,
        public DateTimeImmutable $redeemedAt,
        public KickWebhookRewardEntity $reward,
        public KickWebhookUserEntity $redeemer,
    ) {
        parent::__construct($eventType, $eventVersion, $broadcaster);
    }

    public static function fromArray(array $data, KickWebhookEventTypeEnum $eventType, int $eventVersion): static
    {
        $broadcaster = KickWebhookUserEntity::fromArray($data['broadcaster']);
        $reward = KickWebhookRewardEntity::fromArray($data['reward']);
        $redeemer = KickWebhookUserEntity::fromArray($data['redeemer']);

        return new self(
            eventType: $eventType,
            eventVersion: $eventVersion,
            broadcaster: $broadcaster,
            id: $data['id'],
            userInput: $data['user_input'] ?? null,
            status: $data['status'],
            redeemedAt: new DateTimeImmutable($data['redeemed_at']),
            reward: $reward,
            redeemer: $redeemer,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'broadcaster' => $this->broadcaster->jsonSerialize(),
            'user_input' => $this->userInput,
            'status' => $this->status,
            'redeemed_at' => $this->redeemedAt->format('Y-m-d\TH:i:s\Z'),
            'reward' => $this->reward->jsonSerialize(),
            'redeemer' => $this->redeemer->jsonSerialize(),
        ];
    }
}
