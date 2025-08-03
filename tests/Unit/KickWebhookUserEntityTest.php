<?php

use DanielHe4rt\KickSDK\Events\Webhooks\Entities\KickWebhookUserEntity;

test('can create KickWebhookUserEntity with constructor', function () {
    $entity = new KickWebhookUserEntity(
        isAnonymous: false,
        userId: 123456789,
        username: 'test_user',
        isVerified: true,
        profilePicture: 'https://example.com/avatar.jpg',
        channelSlug: 'test_channel'
    );

    expect($entity->isAnonymous)->toBeFalse()
        ->and($entity->userId)->toBe(123456789)
        ->and($entity->username)->toBe('test_user')
        ->and($entity->isVerified)->toBeTrue()
        ->and($entity->profilePicture)->toBe('https://example.com/avatar.jpg')
        ->and($entity->channelSlug)->toBe('test_channel');
});

test('can create KickWebhookUserEntity from array', function () {
    $data = [
        'is_anonymous' => false,
        'user_id' => 123456789,
        'username' => 'test_user',
        'is_verified' => true,
        'profile_picture' => 'https://example.com/avatar.jpg',
        'channel_slug' => 'test_channel',
    ];

    $entity = KickWebhookUserEntity::fromArray($data);

    expect($entity->isAnonymous)->toBeFalse()
        ->and($entity->userId)->toBe(123456789)
        ->and($entity->username)->toBe('test_user')
        ->and($entity->isVerified)->toBeTrue()
        ->and($entity->profilePicture)->toBe('https://example.com/avatar.jpg')
        ->and($entity->channelSlug)->toBe('test_channel');
});

test('can create anonymous KickWebhookUserEntity', function () {
    $data = [
        'is_anonymous' => true,
        'user_id' => null,
        'username' => null,
        'is_verified' => null,
        'profile_picture' => null,
        'channel_slug' => null,
    ];

    $entity = KickWebhookUserEntity::fromArray($data);

    expect($entity->isAnonymous)->toBeTrue()
        ->and($entity->userId)->toBeNull()
        ->and($entity->username)->toBeNull()
        ->and($entity->isVerified)->toBeNull()
        ->and($entity->profilePicture)->toBeNull()
        ->and($entity->channelSlug)->toBeNull();
});

test('can serialize KickWebhookUserEntity to array', function () {
    $entity = new KickWebhookUserEntity(
        isAnonymous: false,
        userId: 123456789,
        username: 'test_user',
        isVerified: true,
        profilePicture: 'https://example.com/avatar.jpg',
        channelSlug: 'test_channel'
    );

    $serialized = $entity->jsonSerialize();

    expect($serialized)->toBe([
        'is_anonymous' => false,
        'user_id' => 123456789,
        'username' => 'test_user',
        'is_verified' => true,
        'profile_picture' => 'https://example.com/avatar.jpg',
        'channel_slug' => 'test_channel',
        'identity' => null, // identity is not set in this test
    ]);
});
