<?php

namespace DanielHe4rt\KickSDK\Kicks\Entities;

use JsonSerializable;

readonly class KickLeaderboardEntity implements JsonSerializable
{
    /**
     * @param  KickLeaderboardEntryEntity[]  $lifetime
     * @param  KickLeaderboardEntryEntity[]  $month
     * @param  KickLeaderboardEntryEntity[]  $week
     */
    public function __construct(
        public array $lifetime,
        public array $month,
        public array $week,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            lifetime: array_map(
                static fn (array $entry) => KickLeaderboardEntryEntity::fromArray($entry),
                $data['lifetime'] ?? []
            ),
            month: array_map(
                static fn (array $entry) => KickLeaderboardEntryEntity::fromArray($entry),
                $data['month'] ?? []
            ),
            week: array_map(
                static fn (array $entry) => KickLeaderboardEntryEntity::fromArray($entry),
                $data['week'] ?? []
            ),
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'lifetime' => array_map(fn (KickLeaderboardEntryEntity $e) => $e->jsonSerialize(), $this->lifetime),
            'month' => array_map(fn (KickLeaderboardEntryEntity $e) => $e->jsonSerialize(), $this->month),
            'week' => array_map(fn (KickLeaderboardEntryEntity $e) => $e->jsonSerialize(), $this->week),
        ];
    }
}
