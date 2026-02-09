<?php

namespace DanielHe4rt\KickSDK\Events\Webhooks\Payloads;

use DanielHe4rt\KickSDK\Events\Webhooks\Entities\KickWebhookBanMetadataEntity;
use DanielHe4rt\KickSDK\Events\Webhooks\Entities\KickWebhookUserEntity;
use DanielHe4rt\KickSDK\Events\Webhooks\Enums\KickWebhookEventTypeEnum;

readonly class ModerationBannedPayload extends KickWebhookPayload
{
    public function __construct(
        KickWebhookEventTypeEnum $eventType,
        int $eventVersion,
        KickWebhookUserEntity $broadcaster,
        public KickWebhookUserEntity $moderator,
        public KickWebhookUserEntity $bannedUser,
        public KickWebhookBanMetadataEntity $metadata,
    ) {
        parent::__construct($eventType, $eventVersion, $broadcaster);
    }

    public static function fromArray(array $data, KickWebhookEventTypeEnum $eventType, int $eventVersion): static
    {
        $broadcaster = KickWebhookUserEntity::fromArray($data['broadcaster']);
        $moderator = KickWebhookUserEntity::fromArray($data['moderator']);
        $bannedUser = KickWebhookUserEntity::fromArray($data['banned_user']);
        $metadata = KickWebhookBanMetadataEntity::fromArray($data['metadata']);

        return new self(
            eventType: $eventType,
            eventVersion: $eventVersion,
            broadcaster: $broadcaster,
            moderator: $moderator,
            bannedUser: $bannedUser,
            metadata: $metadata,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'broadcaster' => $this->broadcaster->jsonSerialize(),
            'moderator' => $this->moderator->jsonSerialize(),
            'banned_user' => $this->bannedUser->jsonSerialize(),
            'metadata' => $this->metadata->jsonSerialize(),
        ];
    }
}
