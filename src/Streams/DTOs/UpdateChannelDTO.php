<?php

namespace DanielHe4rt\KickSDK\Streams\DTOs;

use JsonSerializable;

readonly class UpdateChannelDTO implements JsonSerializable
{
    /**
     * @param  string[]|null  $customTags  Array of custom tags (max 10 items)
     */
    public function __construct(
        public ?int $categoryId = null,
        public ?string $streamTitle = null,
        public ?array $customTags = null,
    ) {}

    public function jsonSerialize(): array
    {
        $result = [];

        if ($this->categoryId) {
            $result['category_id'] = $this->categoryId;
        }

        if ($this->streamTitle) {
            $result['stream_title'] = $this->streamTitle;
        }

        if ($this->customTags !== null) {
            $result['custom_tags'] = $this->customTags;
        }

        return $result;
    }
}
