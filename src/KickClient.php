<?php

namespace DanielHe4rt\KickSDK;

use DanielHe4rt\KickSDK\Categories\KickCategoryResource;
use DanielHe4rt\KickSDK\Chat\KickChatResource;
use DanielHe4rt\KickSDK\Events\KickEventsResource;
use DanielHe4rt\KickSDK\Kicks\KickKicksResource;
use DanielHe4rt\KickSDK\Livestreams\KickLivestreamResource;
use DanielHe4rt\KickSDK\Moderation\KickModerationResource;
use DanielHe4rt\KickSDK\OAuth\KickOAuthResource;
use DanielHe4rt\KickSDK\PublicKey\KickPublicKeyResource;
use DanielHe4rt\KickSDK\Rewards\KickRewardResource;
use DanielHe4rt\KickSDK\Streams\KickStreamResource;
use DanielHe4rt\KickSDK\Users\KickUserResource;
use GuzzleHttp\Client;

final readonly class KickClient
{
    public Client $client;

    public function __construct(
        public string $clientId,
        public string $clientSecret,
    ) {
        $this->client = new Client([]);
    }

    public function oauth(): KickOAuthResource
    {
        return new KickOAuthResource(
            $this->client,
            $this->clientId,
            $this->clientSecret,
        );
    }

    public function users(string $accessToken): KickUserResource
    {
        return new KickUserResource(
            $this->client,
            $accessToken
        );
    }

    public function streams(string $accessToken): KickStreamResource
    {
        return new KickStreamResource(
            $this->client,
            $accessToken
        );
    }

    public function chat(string $accessToken): KickChatResource
    {
        return new KickChatResource(
            $this->client,
            $accessToken
        );
    }

    public function publicKey(): KickPublicKeyResource
    {
        return new KickPublicKeyResource(
            $this->client
        );
    }

    public function events(string $accessToken): KickEventsResource
    {
        return new KickEventsResource(
            $this->client,
            $accessToken
        );
    }

    public function categories(string $accessToken): KickCategoryResource
    {
        return new KickCategoryResource(
            $this->client,
            $accessToken
        );
    }

    public function rewards(string $accessToken): KickRewardResource
    {
        return new KickRewardResource(
            $this->client,
            $accessToken
        );
    }

    public function moderation(string $accessToken): KickModerationResource
    {
        return new KickModerationResource(
            $this->client,
            $accessToken
        );
    }

    public function livestreams(string $accessToken): KickLivestreamResource
    {
        return new KickLivestreamResource(
            $this->client,
            $accessToken
        );
    }

    public function kicks(string $accessToken): KickKicksResource
    {
        return new KickKicksResource(
            $this->client,
            $accessToken
        );
    }
}
