<?php

use DanielHe4rt\KickSDK\Events\Webhooks\Entities\KickWebhookEmoteEntity;
use DanielHe4rt\KickSDK\Events\Webhooks\Entities\KickWebhookUserEntity;
use DanielHe4rt\KickSDK\Events\Webhooks\Enums\KickWebhookEventTypeEnum;
use DanielHe4rt\KickSDK\Events\Webhooks\Payloads\ChatMessageSentPayload;

test('can create ChatMessageSentPayload with constructor', function () {
    $broadcaster = new KickWebhookUserEntity(
        isAnonymous: false,
        userId: 123456789,
        username: 'broadcaster',
        isVerified: true,
        profilePicture: 'https://example.com/broadcaster.jpg',
        channelSlug: 'broadcaster_channel',
    );

    $sender = new KickWebhookUserEntity(
        isAnonymous: false,
        userId: 987654321,
        username: 'sender',
        isVerified: false,
        profilePicture: 'https://example.com/sender.jpg',
        channelSlug: 'sender_channel'
    );

    $emote = new KickWebhookEmoteEntity(
        emoteId: '12345',
        positions: [['s' => 0, 'e' => 5]]
    );

    $payload = new ChatMessageSentPayload(
        eventType: KickWebhookEventTypeEnum::ChatMessageSent,
        eventVersion: 1,
        broadcaster: $broadcaster,
        messageId: 'msg_123',
        sender: $sender,
        content: 'Hello world!',
        emotes: [$emote],
        createdAt: DateTimeImmutable::createFromFormat('Y-m-d', date('Y-m-d'))
    );

    expect($payload->eventType)->toBe(KickWebhookEventTypeEnum::ChatMessageSent)
        ->and($payload->eventVersion)->toBe(1)
        ->and($payload->broadcaster)->toBe($broadcaster)
        ->and($payload->messageId)->toBe('msg_123')
        ->and($payload->sender)->toBe($sender)
        ->and($payload->content)->toBe('Hello world!')
        ->and($payload->emotes)->toBe([$emote]);
});

test('can create ChatMessageSentPayload from array', function () {
    $data = [
        'broadcaster' => [
            'is_anonymous' => false,
            'user_id' => 123456789,
            'username' => 'broadcaster',
            'is_verified' => true,
            'profile_picture' => 'https://example.com/broadcaster.jpg',
            'channel_slug' => 'broadcaster_channel',
        ],
        'sender' => [
            'is_anonymous' => false,
            'user_id' => 987654321,
            'username' => 'sender',
            'is_verified' => false,
            'profile_picture' => 'https://example.com/sender.jpg',
            'channel_slug' => 'sender_channel',
        ],
        'message_id' => 'msg_123',
        'content' => 'Hello world!',
        'emotes' => [
            [
                'emote_id' => '12345',
                'positions' => [['s' => 0, 'e' => 5]],
            ],
        ],
    ];

    $payload = ChatMessageSentPayload::fromArray(
        $data,
        KickWebhookEventTypeEnum::ChatMessageSent,
        1
    );

    expect($payload->eventType)->toBe(KickWebhookEventTypeEnum::ChatMessageSent)
        ->and($payload->eventVersion)->toBe(1)
        ->and($payload->broadcaster)->toBeInstanceOf(KickWebhookUserEntity::class)
        ->and($payload->broadcaster->username)->toBe('broadcaster')
        ->and($payload->messageId)->toBe('msg_123')
        ->and($payload->sender)->toBeInstanceOf(KickWebhookUserEntity::class)
        ->and($payload->sender->username)->toBe('sender')
        ->and($payload->content)->toBe('Hello world!')
        ->and($payload->emotes)->toHaveCount(1)
        ->and($payload->emotes[0])->toBeInstanceOf(KickWebhookEmoteEntity::class)
        ->and($payload->emotes[0]->emoteId)->toBe('12345');
});

test('can create ChatMessageSentPayload with empty emotes', function () {
    $data = [
        'broadcaster' => [
            'is_anonymous' => false,
            'user_id' => 123456789,
            'username' => 'broadcaster',
            'is_verified' => true,
            'profile_picture' => 'https://example.com/broadcaster.jpg',
            'channel_slug' => 'broadcaster_channel',
        ],
        'sender' => [
            'is_anonymous' => false,
            'user_id' => 987654321,
            'username' => 'sender',
            'is_verified' => false,
            'profile_picture' => 'https://example.com/sender.jpg',
            'channel_slug' => 'sender_channel',
        ],
        'message_id' => 'msg_123',
        'content' => 'Hello world!',
    ];

    $payload = ChatMessageSentPayload::fromArray(
        $data,
        KickWebhookEventTypeEnum::ChatMessageSent,
        1
    );

    expect($payload->emotes)->toBeArray()->toBeEmpty();
});

test('can serialize ChatMessageSentPayload to array', function () {
    $broadcaster = new KickWebhookUserEntity(
        isAnonymous: false,
        userId: 123456789,
        username: 'broadcaster',
        isVerified: true,
        profilePicture: 'https://example.com/broadcaster.jpg',
        channelSlug: 'broadcaster_channel'
    );

    $sender = new KickWebhookUserEntity(
        isAnonymous: false,
        userId: 987654321,
        username: 'sender',
        isVerified: false,
        profilePicture: 'https://example.com/sender.jpg',
        channelSlug: 'sender_channel'
    );

    $emote = new KickWebhookEmoteEntity(
        emoteId: '12345',
        positions: [['s' => 0, 'e' => 5]]
    );

    $payload = new ChatMessageSentPayload(
        eventType: KickWebhookEventTypeEnum::ChatMessageSent,
        eventVersion: 1,
        broadcaster: $broadcaster,
        messageId: 'msg_123',
        sender: $sender,
        content: 'Hello world!',
        emotes: [$emote],
        createdAt: DateTimeImmutable::createFromFormat('Y-m-d', date('Y-m-d'))
    );

    $serialized = $payload->jsonSerialize();

    expect($serialized)->toBeArray()
        ->and($serialized['message_id'])->toBe('msg_123')
        ->and($serialized['content'])->toBe('Hello world!')
        ->and($serialized['broadcaster'])->toBeArray()
        ->and($serialized['sender'])->toBeArray()
        ->and($serialized['emotes'])->toBeArray()->toHaveCount(1);
});
