<?php

namespace DanielHe4rt\KickSDK\Streams\Entities;

use JsonSerializable;

readonly class KickStreamEntity implements JsonSerializable
{
    /**
     * @param  string[]  $custom_tags
     */
    public function __construct(
        public bool $is_live,
        public bool $is_mature,
        public string $key,
        public string $language,
        public string $start_time,
        public string $url,
        public int $viewer_count,
        public ?string $thumbnail = null,
        public array $custom_tags = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            is_live: $data['is_live'],
            is_mature: $data['is_mature'],
            key: $data['key'],
            language: $data['language'],
            start_time: $data['start_time'],
            url: $data['url'],
            viewer_count: $data['viewer_count'],
            thumbnail: $data['thumbnail'] ?? null,
            custom_tags: $data['custom_tags'] ?? [],
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'is_live' => $this->is_live,
            'is_mature' => $this->is_mature,
            'key' => $this->key,
            'language' => $this->language,
            'start_time' => $this->start_time,
            'url' => $this->url,
            'viewer_count' => $this->viewer_count,
            'thumbnail' => $this->thumbnail,
            'custom_tags' => $this->custom_tags,
        ];
    }
}
