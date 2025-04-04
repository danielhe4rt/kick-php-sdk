<?php

use DanielHe4rt\KickSDK\Events\Webhooks\Entities\KickWebhookUserEntity;
use DanielHe4rt\KickSDK\Events\Webhooks\Enums\KickWebhookEventTypeEnum;
use DanielHe4rt\KickSDK\Events\Webhooks\Payloads\ChannelSubscriptionNewPayload;

test('can create ChannelSubscriptionNewPayload with constructor', function () {
    $broadcaster = new KickWebhookUserEntity(
        isAnonymous: false,
        userId: 123456789,
        username: 'broadcaster',
        isVerified: true,
        profilePicture: 'https://example.com/broadcaster.jpg',
        channelSlug: 'broadcaster_channel'
    );

    $subscriber = new KickWebhookUserEntity(
        isAnonymous: false,
        userId: 987654321,
        username: 'subscriber',
        isVerified: false,
        profilePicture: 'https://example.com/subscriber.jpg',
        channelSlug: 'subscriber_channel'
    );

    $createdAt = new DateTimeImmutable('2025-01-14T16:08:06Z');

    $payload = new ChannelSubscriptionNewPayload(
        eventType: KickWebhookEventTypeEnum::ChannelSubscriptionNew,
        eventVersion: 1,
        broadcaster: $broadcaster,
        subscriber: $subscriber,
        duration: 1,
        createdAt: $createdAt
    );

    expect($payload->eventType)->toBe(KickWebhookEventTypeEnum::ChannelSubscriptionNew)
        ->and($payload->eventVersion)->toBe(1)
        ->and($payload->broadcaster)->toBe($broadcaster)
        ->and($payload->subscriber)->toBe($subscriber)
        ->and($payload->duration)->toBe(1)
        ->and($payload->createdAt)->toBe($createdAt);
});

test('can create ChannelSubscriptionNewPayload from array', function () {
    $data = [
        'broadcaster' => [
            'is_anonymous' => false,
            'user_id' => 123456789,
            'username' => 'broadcaster',
            'is_verified' => true,
            'profile_picture' => 'https://example.com/broadcaster.jpg',
            'channel_slug' => 'broadcaster_channel',
        ],
        'subscriber' => [
            'is_anonymous' => false,
            'user_id' => 987654321,
            'username' => 'subscriber',
            'is_verified' => false,
            'profile_picture' => 'https://example.com/subscriber.jpg',
            'channel_slug' => 'subscriber_channel',
        ],
        'duration' => 1,
        'created_at' => '2025-01-14T16:08:06Z',
    ];

    $payload = ChannelSubscriptionNewPayload::fromArray(
        $data,
        KickWebhookEventTypeEnum::ChannelSubscriptionNew,
        1
    );

    expect($payload->eventType)->toBe(KickWebhookEventTypeEnum::ChannelSubscriptionNew)
        ->and($payload->eventVersion)->toBe(1)
        ->and($payload->broadcaster)->toBeInstanceOf(KickWebhookUserEntity::class)
        ->and($payload->broadcaster->username)->toBe('broadcaster')
        ->and($payload->subscriber)->toBeInstanceOf(KickWebhookUserEntity::class)
        ->and($payload->subscriber->username)->toBe('subscriber')
        ->and($payload->duration)->toBe(1)
        ->and($payload->createdAt)->toBeInstanceOf(DateTimeImmutable::class)
        ->and($payload->createdAt->format('Y-m-d\TH:i:s\Z'))->toBe('2025-01-14T16:08:06Z');
});

test('can serialize ChannelSubscriptionNewPayload to array', function () {
    $broadcaster = new KickWebhookUserEntity(
        isAnonymous: false,
        userId: 123456789,
        username: 'broadcaster',
        isVerified: true,
        profilePicture: 'https://example.com/broadcaster.jpg',
        channelSlug: 'broadcaster_channel'
    );

    $subscriber = new KickWebhookUserEntity(
        isAnonymous: false,
        userId: 987654321,
        username: 'subscriber',
        isVerified: false,
        profilePicture: 'https://example.com/subscriber.jpg',
        channelSlug: 'subscriber_channel'
    );

    $createdAt = new DateTimeImmutable('2025-01-14T16:08:06Z');

    $payload = new ChannelSubscriptionNewPayload(
        eventType: KickWebhookEventTypeEnum::ChannelSubscriptionNew,
        eventVersion: 1,
        broadcaster: $broadcaster,
        subscriber: $subscriber,
        duration: 1,
        createdAt: $createdAt
    );

    $serialized = $payload->jsonSerialize();

    expect($serialized)->toBeArray()
        ->and($serialized['broadcaster'])->toBeArray()
        ->and($serialized['subscriber'])->toBeArray()
        ->and($serialized['duration'])->toBe(1)
        ->and($serialized['created_at'])->toBe('2025-01-14T16:08:06Z');
});
