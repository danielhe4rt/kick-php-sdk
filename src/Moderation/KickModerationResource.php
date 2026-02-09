<?php

namespace DanielHe4rt\KickSDK\Moderation;

use DanielHe4rt\KickSDK\Moderation\DTOs\BanUserDTO;
use DanielHe4rt\KickSDK\OAuth\Enums\KickOAuthScopesEnum;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

readonly class KickModerationResource
{
    public const BANS_URI = 'https://api.kick.com/public/v1/moderation/bans';

    public function __construct(
        public Client $client,
        public string $accessToken,
    ) {}

    /**
     * Ban or timeout a user
     *
     * @throws KickModerationException
     */
    public function banUser(BanUserDTO $banDTO): bool
    {
        try {
            $this->client->post(self::BANS_URI, [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $banDTO->jsonSerialize(),
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickModerationException::missingScope(KickOAuthScopesEnum::MODERATION_BAN),
                default => throw KickModerationException::banFailed($e),
            };
        }

        return true;
    }

    /**
     * Unban a user
     *
     * @throws KickModerationException
     */
    public function unbanUser(int $broadcasterUserId, int $userId): bool
    {
        try {
            $this->client->delete(self::BANS_URI, [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'broadcaster_user_id' => $broadcasterUserId,
                    'user_id' => $userId,
                ],
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickModerationException::missingScope(KickOAuthScopesEnum::MODERATION_BAN),
                default => throw KickModerationException::unbanFailed($e),
            };
        }

        return true;
    }
}
