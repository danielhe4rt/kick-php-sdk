<?php

namespace DanielHe4rt\KickSDK\Rewards;

use DanielHe4rt\KickSDK\OAuth\Enums\KickOAuthScopesEnum;
use DanielHe4rt\KickSDK\Rewards\DTOs\CreateRewardDTO;
use DanielHe4rt\KickSDK\Rewards\DTOs\UpdateRewardDTO;
use DanielHe4rt\KickSDK\Rewards\Entities\KickRedemptionEntity;
use DanielHe4rt\KickSDK\Rewards\Entities\KickRewardEntity;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

readonly class KickRewardResource
{
    public const REWARDS_URI = 'https://api.kick.com/public/v1/channels/rewards';

    public const REDEMPTIONS_URI = 'https://api.kick.com/public/v1/channels/rewards/redemptions';

    public function __construct(
        public Client $client,
        public string $accessToken,
    ) {}

    /**
     * List channel rewards
     *
     * @return KickRewardEntity[]
     *
     * @throws KickRewardException
     */
    public function getRewards(): array
    {
        try {
            $response = $this->client->get(self::REWARDS_URI, [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                ],
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickRewardException::missingScope(KickOAuthScopesEnum::CHANNEL_REWARDS_READ),
                default => throw KickRewardException::fetchFailed($e),
            };
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        return array_map(
            static fn (array $reward) => KickRewardEntity::fromArray($reward),
            $responsePayload['data'] ?? []
        );
    }

    /**
     * Create a channel reward
     *
     * @throws KickRewardException
     */
    public function createReward(CreateRewardDTO $rewardDTO): KickRewardEntity
    {
        try {
            $response = $this->client->post(self::REWARDS_URI, [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $rewardDTO->jsonSerialize(),
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickRewardException::missingScope(KickOAuthScopesEnum::CHANNEL_REWARDS_WRITE),
                default => throw KickRewardException::createFailed($e),
            };
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        return KickRewardEntity::fromArray($responsePayload['data']);
    }

    /**
     * Update a channel reward
     *
     * @throws KickRewardException
     */
    public function updateReward(string $rewardId, UpdateRewardDTO $rewardDTO): KickRewardEntity
    {
        try {
            $response = $this->client->patch(self::REWARDS_URI.'/'.$rewardId, [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $rewardDTO->jsonSerialize(),
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickRewardException::missingScope(KickOAuthScopesEnum::CHANNEL_REWARDS_WRITE),
                default => throw KickRewardException::updateFailed($e),
            };
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        return KickRewardEntity::fromArray($responsePayload['data']);
    }

    /**
     * Delete a channel reward
     *
     * @throws KickRewardException
     */
    public function deleteReward(string $rewardId): bool
    {
        try {
            $this->client->delete(self::REWARDS_URI.'/'.$rewardId, [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                ],
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickRewardException::missingScope(KickOAuthScopesEnum::CHANNEL_REWARDS_WRITE),
                default => throw KickRewardException::deleteFailed($e),
            };
        }

        return true;
    }

    /**
     * Get reward redemptions
     *
     * @param  string|null  $rewardId  Filter by reward ID
     * @param  string|null  $status  Filter by status
     * @param  string[]  $ids  Filter by redemption IDs
     * @param  string|null  $cursor  Cursor for pagination
     * @return array{data: KickRedemptionEntity[], cursor: string|null}
     *
     * @throws KickRewardException
     */
    public function getRedemptions(
        ?string $rewardId = null,
        ?string $status = null,
        array $ids = [],
        ?string $cursor = null,
    ): array {
        $query = [];

        if ($rewardId !== null) {
            $query['reward_id'] = $rewardId;
        }

        if ($status !== null) {
            $query['status'] = $status;
        }

        if (! empty($ids)) {
            $query['id'] = $ids;
        }

        if ($cursor !== null) {
            $query['cursor'] = $cursor;
        }

        try {
            $response = $this->client->get(self::REDEMPTIONS_URI, [
                'query' => $query,
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                ],
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickRewardException::missingScope(KickOAuthScopesEnum::CHANNEL_REWARDS_READ),
                default => throw KickRewardException::fetchFailed($e),
            };
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        $redemptions = array_map(
            static fn (array $redemption) => KickRedemptionEntity::fromArray($redemption),
            $responsePayload['data'] ?? []
        );

        return [
            'data' => $redemptions,
            'cursor' => $responsePayload['cursor'] ?? null,
        ];
    }

    /**
     * Accept reward redemptions (batch 1-25 IDs)
     *
     * @param  string[]  $redemptionIds
     *
     * @throws KickRewardException
     */
    public function acceptRedemptions(array $redemptionIds): bool
    {
        if (count($redemptionIds) < 1 || count($redemptionIds) > 25) {
            throw new InvalidArgumentException('Must provide between 1 and 25 redemption IDs');
        }

        try {
            $this->client->post(self::REDEMPTIONS_URI.'/accept', [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => ['ids' => $redemptionIds],
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickRewardException::missingScope(KickOAuthScopesEnum::CHANNEL_REWARDS_WRITE),
                default => throw KickRewardException::redemptionFailed($e),
            };
        }

        return true;
    }

    /**
     * Reject reward redemptions (batch 1-25 IDs)
     *
     * @param  string[]  $redemptionIds
     *
     * @throws KickRewardException
     */
    public function rejectRedemptions(array $redemptionIds): bool
    {
        if (count($redemptionIds) < 1 || count($redemptionIds) > 25) {
            throw new InvalidArgumentException('Must provide between 1 and 25 redemption IDs');
        }

        try {
            $this->client->post(self::REDEMPTIONS_URI.'/reject', [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => ['ids' => $redemptionIds],
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickRewardException::missingScope(KickOAuthScopesEnum::CHANNEL_REWARDS_WRITE),
                default => throw KickRewardException::redemptionFailed($e),
            };
        }

        return true;
    }
}
