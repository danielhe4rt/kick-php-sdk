<?php

namespace DanielHe4rt\KickSDK\Streams;

use DanielHe4rt\KickSDK\OAuth\Enums\KickOAuthScopesEnum;
use DanielHe4rt\KickSDK\Streams\DTOs\UpdateChannelDTO;
use DanielHe4rt\KickSDK\Streams\Entities\KickChannelEntity;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Symfony\Component\HttpFoundation\Response;

readonly class KickStreamResource
{
    public const CHANNELS_URI = 'https://api.kick.com/public/v1/channels';

    public function __construct(
        public Client $client,
        public string $accessToken,
    ) {}

    /**
     * Get the authenticated user's channel
     */
    public function myChannel(): KickChannelEntity
    {
        try {
            $response = $this->client->get(self::CHANNELS_URI, [
                'headers' => ['Authorization' => 'Bearer '.$this->accessToken],
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickStreamException::missingScope(KickOAuthScopesEnum::CHANNEL_READ),
                Response::HTTP_NOT_FOUND => throw KickStreamException::channelNotFound('current user'),
                default => throw KickStreamException::channelFetchFailed($e),
            };
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        if (count($responsePayload['data']) === 0) {
            throw KickStreamException::channelNotFound('current user');
        }

        return KickChannelEntity::fromArray($responsePayload['data'][0]);
    }

    /**
     * Get a channel by its ID
     */
    public function getChannelById(int $channelId): KickChannelEntity
    {
        try {
            $response = $this->client->get(self::CHANNELS_URI, [
                'query' => ['broadcaster_user_id' => $channelId],
                'headers' => ['Authorization' => 'Bearer '.$this->accessToken],
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickStreamException::missingScope(KickOAuthScopesEnum::CHANNEL_READ),
                Response::HTTP_NOT_FOUND => throw KickStreamException::channelNotFound((string) $channelId),
                default => throw KickStreamException::channelFetchFailed($e),
            };
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        if (count($responsePayload['data']) === 0) {
            throw KickStreamException::channelNotFound((string) $channelId);
        }

        return KickChannelEntity::fromArray($responsePayload['data'][0]);
    }

    /**
     * Get multiple channels by their IDs
     *
     * @return array<KickChannelEntity>
     *
     * @throws JsonException
     */
    public function getChannelsById(array $channelIds): array
    {
        try {
            $response = $this->client->get(self::CHANNELS_URI, [
                'query' => ['broadcaster_user_id' => $channelIds],
                'headers' => ['Authorization' => 'Bearer '.$this->accessToken],
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickStreamException::missingScope(KickOAuthScopesEnum::CHANNEL_READ),
                Response::HTTP_NOT_FOUND => throw KickStreamException::channelNotFound(implode(', ', $channelIds)),
                default => throw KickStreamException::channelFetchFailed($e),
            };
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        if (count($responsePayload['data']) === 0) {
            throw KickStreamException::channelNotFound(implode(', ', $channelIds));
        }

        return array_map(
            static fn (array $channel) => KickChannelEntity::fromArray($channel),
            $responsePayload['data']
        );
    }

    /**
     * Get a channel by its slug
     *
     * @throws KickStreamException
     */
    public function getChannelBySlug(string $slug): KickChannelEntity
    {
        try {
            $response = $this->client->get(self::CHANNELS_URI, [
                'query' => ['slug' => $slug],
                'headers' => ['Authorization' => 'Bearer '.$this->accessToken],
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickStreamException::missingScope(KickOAuthScopesEnum::CHANNEL_READ),
                Response::HTTP_NOT_FOUND => throw KickStreamException::channelNotFound($slug),
                default => throw KickStreamException::channelFetchFailed($e),
            };
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        if (count($responsePayload['data']) === 0) {
            throw KickStreamException::channelNotFound($slug);
        }

        return KickChannelEntity::fromArray($responsePayload['data'][0]);
    }

    /**
     * Get multiple channels by their slugs
     *
     * @param  string[]  $slugs
     * @return array<KickChannelEntity>
     *
     * @throws KickStreamException
     * @throws JsonException
     */
    public function getChannelsBySlugs(array $slugs): array
    {
        try {
            $response = $this->client->get(self::CHANNELS_URI, [
                'query' => ['slug' => $slugs],
                'headers' => ['Authorization' => 'Bearer '.$this->accessToken],
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickStreamException::missingScope(KickOAuthScopesEnum::CHANNEL_READ),
                Response::HTTP_NOT_FOUND => throw KickStreamException::channelNotFound(implode(', ', $slugs)),
                default => throw KickStreamException::channelFetchFailed($e),
            };
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        if (count($responsePayload['data']) === 0) {
            throw KickStreamException::channelNotFound(implode(', ', $slugs));
        }

        return array_map(
            static fn (array $channel) => KickChannelEntity::fromArray($channel),
            $responsePayload['data']
        );
    }

    /**
     * Update the authenticated user's channel
     */
    public function updateChannel(UpdateChannelDTO $updateChannelDTO): bool
    {
        try {
            $response = $this->client->patch(self::CHANNELS_URI, [
                'headers' => ['Authorization' => 'Bearer '.$this->accessToken],
                'json' => $updateChannelDTO->jsonSerialize(),
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickStreamException::missingScope(KickOAuthScopesEnum::CHANNEL_WRITE),
                Response::HTTP_NOT_FOUND => throw KickStreamException::channelNotFound('current user'),
                default => throw KickStreamException::channelFetchFailed($e),
            };
        }

        return $response->getStatusCode() === Response::HTTP_NO_CONTENT;
    }
}
