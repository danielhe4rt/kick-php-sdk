<?php

namespace DanielHe4rt\KickSDK\Kicks;

use DanielHe4rt\KickSDK\Kicks\Entities\KickLeaderboardEntity;
use DanielHe4rt\KickSDK\OAuth\Enums\KickOAuthScopesEnum;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

readonly class KickKicksResource
{
    public const LEADERBOARD_URI = 'https://api.kick.com/public/v1/kicks/leaderboard';

    public function __construct(
        public Client $client,
        public string $accessToken,
    ) {}

    /**
     * Get KICKs leaderboard
     *
     * @param  int|null  $top  Number of top entries to return (1-100)
     *
     * @throws KickKicksException
     */
    public function getLeaderboard(?int $top = null): KickLeaderboardEntity
    {
        if ($top !== null && ($top < 1 || $top > 100)) {
            throw new InvalidArgumentException('Top parameter must be between 1 and 100');
        }

        $query = [];
        if ($top !== null) {
            $query['top'] = $top;
        }

        try {
            $response = $this->client->get(self::LEADERBOARD_URI, [
                'query' => $query,
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                ],
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickKicksException::missingScope(KickOAuthScopesEnum::KICKS_READ),
                default => throw KickKicksException::fetchFailed($e),
            };
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        return KickLeaderboardEntity::fromArray($responsePayload['data']);
    }
}
