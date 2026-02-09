<?php

use DanielHe4rt\KickSDK\Streams\Entities\KickCategoryEntity;
use DanielHe4rt\KickSDK\Streams\Entities\KickChannelEntity;
use DanielHe4rt\KickSDK\Streams\Entities\KickStreamEntity;

test('can create KickChannelEntity with constructor', function () {
    $category = new KickCategoryEntity(
        id: 1,
        name: 'Just Chatting',
        thumbnail: 'https://example.com/category.jpg'
    );

    $stream = new KickStreamEntity(
        is_live: true,
        is_mature: false,
        key: 'stream_key',
        language: 'en',
        start_time: '2023-01-01T12:00:00Z',
        url: 'https://example.com/stream',
        viewer_count: 1000
    );

    $entity = new KickChannelEntity(
        banner_picture: 'https://example.com/banner.jpg',
        broadcaster_user_id: 123456,
        category: $category,
        channel_description: 'This is a test channel',
        slug: 'test_channel',
        stream: $stream,
        stream_title: 'Test Stream'
    );

    expect($entity->banner_picture)->toBe('https://example.com/banner.jpg')
        ->and($entity->broadcaster_user_id)->toBe(123456)
        ->and($entity->category)->toBe($category)
        ->and($entity->channel_description)->toBe('This is a test channel')
        ->and($entity->slug)->toBe('test_channel')
        ->and($entity->stream)->toBe($stream)
        ->and($entity->stream_title)->toBe('Test Stream');
});

test('can create KickChannelEntity with null stream', function () {
    $category = new KickCategoryEntity(
        id: 1,
        name: 'Just Chatting',
        thumbnail: 'https://example.com/category.jpg'
    );

    $entity = new KickChannelEntity(
        banner_picture: 'https://example.com/banner.jpg',
        broadcaster_user_id: 123456,
        category: $category,
        channel_description: 'This is a test channel',
        slug: 'test_channel',
        stream: null,
        stream_title: 'Test Stream'
    );

    expect($entity->banner_picture)->toBe('https://example.com/banner.jpg')
        ->and($entity->broadcaster_user_id)->toBe(123456)
        ->and($entity->category)->toBe($category)
        ->and($entity->channel_description)->toBe('This is a test channel')
        ->and($entity->slug)->toBe('test_channel')
        ->and($entity->stream)->toBeNull()
        ->and($entity->stream_title)->toBe('Test Stream');
});

test('can create KickChannelEntity from array with stream', function () {
    $data = [
        'banner_picture' => 'https://example.com/banner.jpg',
        'broadcaster_user_id' => 123456,
        'category' => [
            'id' => 1,
            'name' => 'Just Chatting',
            'thumbnail' => 'https://example.com/category.jpg',
        ],
        'channel_description' => 'This is a test channel',
        'slug' => 'test_channel',
        'stream' => [
            'is_live' => true,
            'is_mature' => false,
            'key' => 'stream_key',
            'language' => 'en',
            'start_time' => '2023-01-01T12:00:00Z',
            'url' => 'https://example.com/stream',
            'viewer_count' => 1000,
        ],
        'stream_title' => 'Test Stream',
    ];

    // Mock the var_dump function to prevent output during tests
    $this->expectOutputString('');

    $entity = KickChannelEntity::fromArray($data);

    expect($entity->banner_picture)->toBe('https://example.com/banner.jpg')
        ->and($entity->broadcaster_user_id)->toBe(123456)
        ->and($entity->category)->toBeInstanceOf(KickCategoryEntity::class)
        ->and($entity->category->id)->toBe(1)
        ->and($entity->channel_description)->toBe('This is a test channel')
        ->and($entity->slug)->toBe('test_channel')
        ->and($entity->stream)->toBeInstanceOf(KickStreamEntity::class)
        ->and($entity->stream->is_live)->toBeTrue()
        ->and($entity->stream_title)->toBe('Test Stream');
});

test('can create KickChannelEntity from array without stream', function () {
    $data = [
        'banner_picture' => 'https://example.com/banner.jpg',
        'broadcaster_user_id' => 123456,
        'category' => [
            'id' => 1,
            'name' => 'Just Chatting',
            'thumbnail' => 'https://example.com/category.jpg',
        ],
        'channel_description' => 'This is a test channel',
        'slug' => 'test_channel',
        'stream_title' => 'Test Stream',
    ];

    // Mock the var_dump function to prevent output during tests
    $this->expectOutputString('');

    $entity = KickChannelEntity::fromArray($data);

    expect($entity->banner_picture)->toBe('https://example.com/banner.jpg')
        ->and($entity->broadcaster_user_id)->toBe(123456)
        ->and($entity->category)->toBeInstanceOf(KickCategoryEntity::class)
        ->and($entity->category->id)->toBe(1)
        ->and($entity->channel_description)->toBe('This is a test channel')
        ->and($entity->slug)->toBe('test_channel')
        ->and($entity->stream)->toBeNull()
        ->and($entity->stream_title)->toBe('Test Stream');
});

test('can serialize KickChannelEntity with stream', function () {
    $category = new KickCategoryEntity(
        id: 1,
        name: 'Just Chatting',
        thumbnail: 'https://example.com/category.jpg'
    );

    $stream = new KickStreamEntity(
        is_live: true,
        is_mature: false,
        key: 'stream_key',
        language: 'en',
        start_time: '2023-01-01T12:00:00Z',
        url: 'https://example.com/stream',
        viewer_count: 1000
    );

    $entity = new KickChannelEntity(
        banner_picture: 'https://example.com/banner.jpg',
        broadcaster_user_id: 123456,
        category: $category,
        channel_description: 'This is a test channel',
        slug: 'test_channel',
        stream: $stream,
        stream_title: 'Test Stream'
    );

    $serialized = $entity->jsonSerialize();

    expect($serialized)->toBe([
        'banner_picture' => 'https://example.com/banner.jpg',
        'broadcaster_user_id' => 123456,
        'category' => [
            'id' => 1,
            'name' => 'Just Chatting',
            'thumbnail' => 'https://example.com/category.jpg',
        ],
        'channel_description' => 'This is a test channel',
        'slug' => 'test_channel',
        'stream' => [
            'is_live' => true,
            'is_mature' => false,
            'key' => 'stream_key',
            'language' => 'en',
            'start_time' => '2023-01-01T12:00:00Z',
            'url' => 'https://example.com/stream',
            'viewer_count' => 1000,
            'thumbnail' => null,
            'custom_tags' => [],
        ],
        'stream_title' => 'Test Stream',
        'active_subscribers_count' => null,
        'canceled_subscribers_count' => null,
    ]);
});

test('can serialize KickChannelEntity without stream', function () {
    $category = new KickCategoryEntity(
        id: 1,
        name: 'Just Chatting',
        thumbnail: 'https://example.com/category.jpg'
    );

    $entity = new KickChannelEntity(
        banner_picture: 'https://example.com/banner.jpg',
        broadcaster_user_id: 123456,
        category: $category,
        channel_description: 'This is a test channel',
        slug: 'test_channel',
        stream: null,
        stream_title: 'Test Stream'
    );

    $serialized = $entity->jsonSerialize();

    expect($serialized)->toBe([
        'banner_picture' => 'https://example.com/banner.jpg',
        'broadcaster_user_id' => 123456,
        'category' => [
            'id' => 1,
            'name' => 'Just Chatting',
            'thumbnail' => 'https://example.com/category.jpg',
        ],
        'channel_description' => 'This is a test channel',
        'slug' => 'test_channel',
        'stream' => null,
        'stream_title' => 'Test Stream',
        'active_subscribers_count' => null,
        'canceled_subscribers_count' => null,
    ]);
});
