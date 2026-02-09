<?php

namespace DanielHe4rt\KickSDK\OAuth\Entities;

class KickAppAccessTokenEntity
{
    public function __construct(
        public string $accessToken,
        public int $expires_in,
        public string $token_type,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['access_token'],
            $data['expires_in'],
            $data['token_type']
        );
    }
}
