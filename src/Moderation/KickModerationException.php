<?php

namespace DanielHe4rt\KickSDK\Moderation;

use DanielHe4rt\KickSDK\OAuth\Enums\KickOAuthScopesEnum;
use InvalidArgumentException;
use Throwable;

class KickModerationException extends InvalidArgumentException
{
    public static function banFailed(Throwable $exception): self
    {
        $message = sprintf('[Kick Ban Failed] Context: %s', $exception->getMessage());

        return new self(message: $message, code: $exception->getCode());
    }

    public static function unbanFailed(Throwable $exception): self
    {
        $message = sprintf('[Kick Unban Failed] Context: %s', $exception->getMessage());

        return new self(message: $message, code: $exception->getCode());
    }

    public static function missingScope(KickOAuthScopesEnum $enum): self
    {
        $message = sprintf('[Kick Unauthorized] Access denied. You may be missing the required scope (%s).', $enum->value);

        return new self(message: $message, code: 401);
    }
}
