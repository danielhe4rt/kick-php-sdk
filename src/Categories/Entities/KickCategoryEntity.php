<?php

namespace DanielHe4rt\KickSDK\Categories\Entities;

use JsonSerializable;

readonly class KickCategoryEntity implements JsonSerializable
{
    /**
     * @param  string[]  $tags
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $thumbnail,
        public array $tags = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            thumbnail: $data['thumbnail'],
            tags: $data['tags'] ?? [],
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'thumbnail' => $this->thumbnail,
            'tags' => $this->tags,
        ];
    }
}
