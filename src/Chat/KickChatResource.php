<?php

namespace DanielHe4rt\KickSDK\Chat;

use DanielHe4rt\KickSDK\Chat\DTOs\SendChatMessageDTO;
use DanielHe4rt\KickSDK\Chat\Entities\KickChatMessageEntity;
use DanielHe4rt\KickSDK\OAuth\Enums\KickOAuthScopesEnum;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

readonly class KickChatResource
{
    public const CHAT_URI = 'https://api.kick.com/public/v1/chat';

    public function __construct(
        public Client $client,
        public string $accessToken,
    ) {}

    /**
     * Send a chat message to a channel
     *
     * @throws KickChatException
     */
    public function sendMessage(SendChatMessageDTO $messageDTO): KickChatMessageEntity
    {
        try {
            $response = $this->client->post(self::CHAT_URI, [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $messageDTO->jsonSerialize(),
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickChatException::missingScope(KickOAuthScopesEnum::CHAT_WRITE),
                Response::HTTP_FORBIDDEN => throw KickChatException::forbidden('You do not have permission to send messages to this channel.'),
                Response::HTTP_NOT_FOUND => throw KickChatException::channelNotFound($messageDTO->broadcaster_user_id ?? 'bot channel'),
                default => throw KickChatException::messageSendFailed($e),
            };
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        return KickChatMessageEntity::fromArray($responsePayload['data']);
    }

    /**
     * Delete a chat message
     *
     * @param  string  $messageId  The UUID of the message to delete
     * @return bool Whether the deletion was successful (204 No Content)
     *
     * @throws KickChatException
     */
    public function deleteMessage(string $messageId): bool
    {
        try {
            $this->client->delete(self::CHAT_URI.'/'.$messageId, [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                ],
            ]);
        } catch (GuzzleException $e) {
            match ($e->getCode()) {
                Response::HTTP_UNAUTHORIZED => throw KickChatException::missingScope(KickOAuthScopesEnum::MODERATION_CHAT_MESSAGE_MANAGE),
                Response::HTTP_FORBIDDEN => throw KickChatException::forbidden('You do not have permission to delete messages in this channel.'),
                Response::HTTP_NOT_FOUND => throw KickChatException::messageNotFound($messageId),
                default => throw KickChatException::messageDeleteFailed($e),
            };
        }

        return true;
    }
}
