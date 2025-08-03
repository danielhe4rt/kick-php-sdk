<?php

namespace DanielHe4rt\KickSDK\Events\Webhooks\Entities;

use JsonSerializable;

readonly class KickWebhookLivestreamMetadataEntity implements JsonSerializable
{
    /**
     * @param  string  $title  Stream title
     * @param  string  $language  Stream language code (e.g., 'en')
     * @param  bool  $hasMatureContent  Whether the stream has mature content
     * @param  array  $category  Category information (id, name, thumbnail)
     */
    public function __construct(
        public string $title,
        public string $language,
        public bool $hasMatureContent,
        public int $categoryId,
        public string $categoryName,
        public string $categoryThumbnail,
    ) {}

    /**
     * Create a new KickWebhookLivestreamMetadataEntity from an array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'] ?? '',
            language: $data['language'] ?? '',
            hasMatureContent: $data['has_mature_content'] ?? false,
            categoryId: $data['category']['id'] ?? null,
            categoryName: $data['category']['name'] ?? null,
            categoryThumbnail: $data['category']['thumbnail'] ?? null,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'title' => $this->title,
            'language' => $this->language,
            'has_mature_content' => $this->hasMatureContent,
            'category' => [
                'id' => $this->categoryId,
                'name' => $this->categoryName,
                'thumbnail' => $this->categoryThumbnail,
            ],
        ];
    }
}
