<?php

namespace DanielHe4rt\KickSDK\Livestreams;

use DanielHe4rt\KickSDK\OAuth\Enums\KickOAuthScopesEnum;
use InvalidArgumentException;
use Throwable;

class KickLivestreamException extends InvalidArgumentException
{
    public static function fetchFailed(Throwable $exception): self
    {
        $message = sprintf('[Kick Livestream Fetch Failed] Context: %s', $exception->getMessage());

        return new self(message: $message, code: $exception->getCode());
    }

    public static function missingScope(KickOAuthScopesEnum $enum): self
    {
        $message = sprintf('[Kick Unauthorized] Access denied. You may be missing the required scope (%s).', $enum->value);

        return new self(message: $message, code: 401);
    }
}
