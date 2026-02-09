<?php

namespace DanielHe4rt\KickSDK\Events\Webhooks\Entities;

use JsonSerializable;

readonly class KickWebhookUserEntity implements JsonSerializable
{
    /**
     * @param  bool  $isAnonymous  Whether the user is anonymous
     * @param  int|null  $userId  User ID (null if anonymous)
     * @param  string|null  $username  Username (null if anonymous)
     * @param  bool|null  $isVerified  Whether the user is verified (null if anonymous)
     * @param  string|null  $profilePicture  URL to the user's profile picture (null if anonymous)
     * @param  string|null  $channelSlug  Channel slug (null if anonymous)
     * @param  KickWebhookIdentityEntity|null  $identity  User identity with color and badges
     */
    public function __construct(
        public bool $isAnonymous,
        public ?int $userId,
        public ?string $username,
        public ?bool $isVerified,
        public ?string $profilePicture,
        public ?string $channelSlug,
        public ?KickWebhookIdentityEntity $identity = null,
    ) {}

    /**
     * Create a new KickWebhookUserEntity from an array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            isAnonymous: $data['is_anonymous'] ?? false,
            userId: $data['user_id'] ?? null,
            username: $data['username'] ?? null,
            isVerified: $data['is_verified'] ?? null,
            profilePicture: $data['profile_picture'] ?? null,
            channelSlug: $data['channel_slug'] ?? null,
            identity: isset($data['identity']) && is_array($data['identity'])
                ? KickWebhookIdentityEntity::fromArray($data['identity'])
                : null,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'is_anonymous' => $this->isAnonymous,
            'user_id' => $this->userId,
            'username' => $this->username,
            'is_verified' => $this->isVerified,
            'profile_picture' => $this->profilePicture,
            'channel_slug' => $this->channelSlug,
            'identity' => $this->identity?->jsonSerialize(),
        ];
    }
}
