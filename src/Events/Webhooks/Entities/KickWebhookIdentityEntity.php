<?php

namespace DanielHe4rt\KickSDK\Events\Webhooks\Entities;

use JsonSerializable;

readonly class KickWebhookIdentityEntity implements JsonSerializable
{
    /**
     * @param  string  $usernameColor  Hex color code for the username
     * @param  KickWebhookBadgeEntity[]  $badges  Array of badge objects
     */
    public function __construct(
        public string $usernameColor,
        public array $badges = [],
    ) {}

    public static function fromArray(array $data): self
    {
        $badges = [];
        foreach ($data['badges'] ?? [] as $badgeData) {
            $badges[] = KickWebhookBadgeEntity::fromArray($badgeData);
        }

        return new self(
            usernameColor: $data['username_color'] ?? '',
            badges: $badges,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'username_color' => $this->usernameColor,
            'badges' => array_map(fn (KickWebhookBadgeEntity $badge) => $badge->jsonSerialize(), $this->badges),
        ];
    }
}
