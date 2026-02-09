<?php

namespace DanielHe4rt\KickSDK\Rewards\Entities;

use JsonSerializable;

readonly class KickRewardEntity implements JsonSerializable
{
    public function __construct(
        public string $id,
        public string $title,
        public int $cost,
        public ?string $description,
        public ?string $backgroundColor,
        public bool $isEnabled,
        public bool $isUserInputRequired,
        public bool $isPaused,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            title: $data['title'],
            cost: $data['cost'],
            description: $data['description'] ?? null,
            backgroundColor: $data['background_color'] ?? null,
            isEnabled: $data['is_enabled'] ?? true,
            isUserInputRequired: $data['is_user_input_required'] ?? false,
            isPaused: $data['is_paused'] ?? false,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'cost' => $this->cost,
            'description' => $this->description,
            'background_color' => $this->backgroundColor,
            'is_enabled' => $this->isEnabled,
            'is_user_input_required' => $this->isUserInputRequired,
            'is_paused' => $this->isPaused,
        ];
    }
}
