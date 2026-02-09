<?php

namespace DanielHe4rt\KickSDK\Chat;

use DanielHe4rt\KickSDK\OAuth\Enums\KickOAuthScopesEnum;
use InvalidArgumentException;
use Throwable;

class KickChatException extends InvalidArgumentException
{
    /**
     * Create an exception for when a message fails to send
     */
    public static function messageSendFailed(Throwable $exception): self
    {
        $message = sprintf('[Kick Chat Send Failed] Context: %s', $exception->getMessage());

        return new self(message: $message, code: $exception->getCode());
    }

    /**
     * Create an exception for when a channel is not found
     */
    public static function channelNotFound(string|int $channelId): self
    {
        $message = sprintf("[Kick Channel Not Found] Channel with ID '%s' was not found.", $channelId);

        return new self(message: $message);
    }

    /**
     * Create an exception for when a required scope is missing
     */
    public static function missingScope(KickOAuthScopesEnum $enum): self
    {
        $message = sprintf('[Kick Unauthorized] Access denied. You may be missing the required scope (%s).', $enum->value);

        return new self(message: $message, code: 401);
    }

    /**
     * Create an exception for when access is forbidden
     */
    public static function forbidden(string $reason): self
    {
        $message = sprintf('[Kick Forbidden] %s', $reason);

        return new self(message: $message, code: 403);
    }

    /**
     * Create an exception for when a message deletion fails
     */
    public static function messageDeleteFailed(Throwable $exception): self
    {
        $message = sprintf('[Kick Chat Delete Failed] Context: %s', $exception->getMessage());

        return new self(message: $message, code: $exception->getCode());
    }

    /**
     * Create an exception for when a message is not found
     */
    public static function messageNotFound(string $messageId): self
    {
        $message = sprintf("[Kick Message Not Found] Message with ID '%s' was not found.", $messageId);

        return new self(message: $message, code: 404);
    }
}
