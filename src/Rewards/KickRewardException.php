<?php

namespace DanielHe4rt\KickSDK\Rewards;

use DanielHe4rt\KickSDK\OAuth\Enums\KickOAuthScopesEnum;
use InvalidArgumentException;
use Throwable;

class KickRewardException extends InvalidArgumentException
{
    public static function fetchFailed(Throwable $exception): self
    {
        $message = sprintf('[Kick Reward Fetch Failed] Context: %s', $exception->getMessage());

        return new self(message: $message, code: $exception->getCode());
    }

    public static function createFailed(Throwable $exception): self
    {
        $message = sprintf('[Kick Reward Create Failed] Context: %s', $exception->getMessage());

        return new self(message: $message, code: $exception->getCode());
    }

    public static function updateFailed(Throwable $exception): self
    {
        $message = sprintf('[Kick Reward Update Failed] Context: %s', $exception->getMessage());

        return new self(message: $message, code: $exception->getCode());
    }

    public static function deleteFailed(Throwable $exception): self
    {
        $message = sprintf('[Kick Reward Delete Failed] Context: %s', $exception->getMessage());

        return new self(message: $message, code: $exception->getCode());
    }

    public static function redemptionFailed(Throwable $exception): self
    {
        $message = sprintf('[Kick Redemption Failed] Context: %s', $exception->getMessage());

        return new self(message: $message, code: $exception->getCode());
    }

    public static function missingScope(KickOAuthScopesEnum $enum): self
    {
        $message = sprintf('[Kick Unauthorized] Access denied. You may be missing the required scope (%s).', $enum->value);

        return new self(message: $message, code: 401);
    }
}
