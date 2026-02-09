<?php

namespace DanielHe4rt\KickSDK\Moderation\DTOs;

use InvalidArgumentException;
use JsonSerializable;

readonly class BanUserDTO implements JsonSerializable
{
    /**
     * @param  int  $broadcasterUserId  The broadcaster's user ID
     * @param  int  $userId  The user to ban
     * @param  int|null  $duration  Timeout duration in minutes (1-10080). Omit for permanent ban.
     * @param  string|null  $reason  Ban reason (max 100 characters)
     */
    public function __construct(
        public int $broadcasterUserId,
        public int $userId,
        public ?int $duration = null,
        public ?string $reason = null,
    ) {
        if ($this->duration !== null && ($this->duration < 1 || $this->duration > 10080)) {
            throw new InvalidArgumentException('Duration must be between 1 and 10080 minutes');
        }

        if ($this->reason !== null && strlen($this->reason) > 100) {
            throw new InvalidArgumentException('Reason cannot exceed 100 characters');
        }
    }

    public function jsonSerialize(): array
    {
        $result = [
            'broadcaster_user_id' => $this->broadcasterUserId,
            'user_id' => $this->userId,
        ];

        if ($this->duration !== null) {
            $result['duration'] = $this->duration;
        }

        if ($this->reason !== null) {
            $result['reason'] = $this->reason;
        }

        return $result;
    }
}
