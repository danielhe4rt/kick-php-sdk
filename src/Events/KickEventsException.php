<?php

namespace Danielhe4rt\KickSDK\Events;

use Danielhe4rt\KickSDK\OAuth\Enums\KickOAuthScopesEnum;
use InvalidArgumentException;
use Throwable;

class KickEventsException extends InvalidArgumentException
{
    /**
     * Create an exception for when event subscriptions retrieval fails
     * 
     * @param Throwable $exception
     * @return self
     */
    public static function retrievalFailed(Throwable $exception): self
    {
        $message = sprintf("[Kick Events Retrieval Failed] Context: %s", $exception->getMessage());
        return new self(message: $message, code: $exception->getCode());
    }

    /**
     * Create an exception for when event subscription creation fails
     * 
     * @param Throwable $exception
     * @return self
     */
    public static function creationFailed(Throwable $exception): self
    {
        $message = sprintf("[Kick Events Creation Failed] Context: %s", $exception->getMessage());
        return new self(message: $message, code: $exception->getCode());
    }

    /**
     * Create an exception for when event subscription deletion fails
     * 
     * @param Throwable $exception
     * @return self
     */
    public static function deletionFailed(Throwable $exception): self
    {
        $message = sprintf("[Kick Events Deletion Failed] Context: %s", $exception->getMessage());
        return new self(message: $message, code: $exception->getCode());
    }

    /**
     * Create an exception for when a required scope is missing
     * 
     * @param KickOAuthScopesEnum $enum
     * @return self
     */
    public static function missingScope(KickOAuthScopesEnum $enum): self
    {
        $message = sprintf("[Kick Unauthorized] Access denied. You may be missing the required scope (%s).", $enum->value);
        return new self(message: $message, code: 401);
    }

    /**
     * Create an exception for when access is forbidden
     * 
     * @param string $reason
     * @return self
     */
    public static function forbidden(string $reason): self
    {
        $message = sprintf("[Kick Forbidden] %s", $reason);
        return new self(message: $message, code: 403);
    }
} 