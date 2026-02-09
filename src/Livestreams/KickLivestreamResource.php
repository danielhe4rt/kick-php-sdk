<?php

namespace DanielHe4rt\KickSDK\Livestreams;

use DanielHe4rt\KickSDK\Livestreams\Entities\KickLivestreamEntity;
use DanielHe4rt\KickSDK\Livestreams\Entities\KickLivestreamStatsEntity;
use DanielHe4rt\KickSDK\OAuth\Enums\KickOAuthScopesEnum;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

readonly class KickLivestreamResource
{
    public const LIVESTREAMS_URI = 'https://api.kick.com/public/v1/livestreams';

    public function __construct(
        public Client $client,
        public string $accessToken,
    ) {}

    /**
     * Get live streams with optional filters
     *
     * @param  int[]  $broadcasterUserIds  Filter by broadcaster user IDs
     * @param  int|null  $categoryId  Filter by category ID
     * @param  string|null  $language  Filter by language code
     * @param  int  $limit  Number of results
     * @param  string|null  $sort  Sort order
     * @param  string|null  $cursor  Cursor for pagination
     * @return array{data: KickLivestreamEntity[], cursor: string|null}
     *
     * @throws KickLivestreamException
     */
    public function getLivestreams(
        array $broadcasterUserIds = [],
        ?int $categoryId = null,
        ?string $language = null,
        int $limit = 25,
        ?string $sort = null,
        ?string $cursor = null,
    ): array {
        $query = ['limit' => $limit];

        if (! empty($broadcasterUserIds)) {
            $query['broadcaster_user_id'] = $broadcasterUserIds;
        }

        if ($categoryId !== null) {
            $query['category_id'] = $categoryId;
        }

        if ($language !== null) {
            $query['language'] = $language;
        }

        if ($sort !== null) {
            $query['sort'] = $sort;
        }

        if ($cursor !== null) {
            $query['cursor'] = $cursor;
        }

        try {
            $response = $this->client->get(self::LIVESTREAMS_URI, [
                'query' => $query,
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                ],
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickLivestreamException::missingScope(KickOAuthScopesEnum::CHANNEL_READ),
                default => throw KickLivestreamException::fetchFailed($e),
            };
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        $livestreams = array_map(
            static fn (array $livestream) => KickLivestreamEntity::fromArray($livestream),
            $responsePayload['data'] ?? []
        );

        return [
            'data' => $livestreams,
            'cursor' => $responsePayload['cursor'] ?? null,
        ];
    }

    /**
     * Get total livestream count
     *
     * @throws KickLivestreamException
     */
    public function getStats(): KickLivestreamStatsEntity
    {
        try {
            $response = $this->client->get(self::LIVESTREAMS_URI.'/stats', [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                ],
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickLivestreamException::missingScope(KickOAuthScopesEnum::CHANNEL_READ),
                default => throw KickLivestreamException::fetchFailed($e),
            };
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        return KickLivestreamStatsEntity::fromArray($responsePayload['data']);
    }
}
