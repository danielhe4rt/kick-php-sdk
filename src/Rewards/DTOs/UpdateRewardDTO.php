<?php

namespace DanielHe4rt\KickSDK\Rewards\DTOs;

use JsonSerializable;

readonly class UpdateRewardDTO implements JsonSerializable
{
    public function __construct(
        public ?string $title = null,
        public ?int $cost = null,
        public ?string $description = null,
        public ?string $backgroundColor = null,
        public ?bool $isEnabled = null,
        public ?bool $isUserInputRequired = null,
        public ?bool $isPaused = null,
    ) {}

    public function jsonSerialize(): array
    {
        $result = [];

        if ($this->title !== null) {
            $result['title'] = $this->title;
        }

        if ($this->cost !== null) {
            $result['cost'] = $this->cost;
        }

        if ($this->description !== null) {
            $result['description'] = $this->description;
        }

        if ($this->backgroundColor !== null) {
            $result['background_color'] = $this->backgroundColor;
        }

        if ($this->isEnabled !== null) {
            $result['is_enabled'] = $this->isEnabled;
        }

        if ($this->isUserInputRequired !== null) {
            $result['is_user_input_required'] = $this->isUserInputRequired;
        }

        if ($this->isPaused !== null) {
            $result['is_paused'] = $this->isPaused;
        }

        return $result;
    }
}
