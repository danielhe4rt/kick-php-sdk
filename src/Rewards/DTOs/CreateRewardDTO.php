<?php

namespace DanielHe4rt\KickSDK\Rewards\DTOs;

use InvalidArgumentException;
use JsonSerializable;

readonly class CreateRewardDTO implements JsonSerializable
{
    public function __construct(
        public string $title,
        public int $cost,
        public ?string $description = null,
        public ?string $backgroundColor = null,
        public bool $isEnabled = true,
        public bool $isUserInputRequired = false,
        public bool $isPaused = false,
    ) {
        if ($this->cost < 1) {
            throw new InvalidArgumentException('Reward cost must be at least 1');
        }
    }

    public function jsonSerialize(): array
    {
        $result = [
            'title' => $this->title,
            'cost' => $this->cost,
            'is_enabled' => $this->isEnabled,
            'is_user_input_required' => $this->isUserInputRequired,
            'is_paused' => $this->isPaused,
        ];

        if ($this->description !== null) {
            $result['description'] = $this->description;
        }

        if ($this->backgroundColor !== null) {
            $result['background_color'] = $this->backgroundColor;
        }

        return $result;
    }
}
