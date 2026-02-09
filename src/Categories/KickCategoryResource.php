<?php

namespace DanielHe4rt\KickSDK\Categories;

use DanielHe4rt\KickSDK\Categories\Entities\KickCategoryEntity;
use DanielHe4rt\KickSDK\OAuth\Enums\KickOAuthScopesEnum;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

readonly class KickCategoryResource
{
    public const CATEGORIES_URI = 'https://api.kick.com/public/v2/categories';

    public function __construct(
        public Client $client,
        public string $accessToken,
    ) {}

    /**
     * Get categories with optional filters
     *
     * @param  string[]  $names  Filter by category names
     * @param  string[]  $tags  Filter by tags
     * @param  int[]  $ids  Filter by category IDs
     * @param  int  $limit  Number of results (1-1000)
     * @param  string|null  $cursor  Cursor for pagination
     * @return array{data: KickCategoryEntity[], cursor: string|null}
     *
     * @throws KickCategoryException
     */
    public function getCategories(
        array $names = [],
        array $tags = [],
        array $ids = [],
        int $limit = 25,
        ?string $cursor = null,
    ): array {
        $query = ['limit' => $limit];

        if (! empty($names)) {
            $query['name'] = $names;
        }

        if (! empty($tags)) {
            $query['tag'] = $tags;
        }

        if (! empty($ids)) {
            $query['id'] = $ids;
        }

        if ($cursor !== null) {
            $query['cursor'] = $cursor;
        }

        try {
            $response = $this->client->get(self::CATEGORIES_URI, [
                'query' => $query,
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                ],
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickCategoryException::missingScope(KickOAuthScopesEnum::CHANNEL_READ),
                default => throw KickCategoryException::fetchFailed($e),
            };
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        $categories = array_map(
            static fn (array $category) => KickCategoryEntity::fromArray($category),
            $responsePayload['data'] ?? []
        );

        return [
            'data' => $categories,
            'cursor' => $responsePayload['cursor'] ?? null,
        ];
    }
}
