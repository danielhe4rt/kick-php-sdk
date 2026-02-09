<?php

namespace DanielHe4rt\KickSDK\Livestreams\Entities;

use JsonSerializable;

readonly class KickLivestreamEntity implements JsonSerializable
{
    /**
     * @param  string[]  $customTags
     */
    public function __construct(
        public int $broadcasterUserId,
        public string $slug,
        public string $streamTitle,
        public string $language,
        public bool $hasMatureContent,
        public int $viewerCount,
        public ?string $thumbnail,
        public ?string $profilePicture,
        public ?string $startedAt,
        public ?array $category,
        public array $customTags = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            broadcasterUserId: $data['broadcaster_user_id'],
            slug: $data['slug'],
            streamTitle: $data['stream_title'],
            language: $data['language'],
            hasMatureContent: $data['has_mature_content'] ?? false,
            viewerCount: $data['viewer_count'],
            thumbnail: $data['thumbnail'] ?? null,
            profilePicture: $data['profile_picture'] ?? null,
            startedAt: $data['started_at'] ?? null,
            category: $data['category'] ?? null,
            customTags: $data['custom_tags'] ?? [],
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'broadcaster_user_id' => $this->broadcasterUserId,
            'slug' => $this->slug,
            'stream_title' => $this->streamTitle,
            'language' => $this->language,
            'has_mature_content' => $this->hasMatureContent,
            'viewer_count' => $this->viewerCount,
            'thumbnail' => $this->thumbnail,
            'profile_picture' => $this->profilePicture,
            'started_at' => $this->startedAt,
            'category' => $this->category,
            'custom_tags' => $this->customTags,
        ];
    }
}
