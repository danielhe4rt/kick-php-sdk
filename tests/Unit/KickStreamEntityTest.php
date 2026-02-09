<?php

use DanielHe4rt\KickSDK\Streams\Entities\KickStreamEntity;

test('can create KickStreamEntity with constructor', function () {
    $entity = new KickStreamEntity(
        is_live: true,
        is_mature: false,
        key: 'stream_key',
        language: 'en',
        start_time: '2023-01-01T12:00:00Z',
        url: 'https://example.com/stream',
        viewer_count: 1000
    );

    expect($entity->is_live)->toBeTrue()
        ->and($entity->is_mature)->toBeFalse()
        ->and($entity->key)->toBe('stream_key')
        ->and($entity->language)->toBe('en')
        ->and($entity->start_time)->toBe('2023-01-01T12:00:00Z')
        ->and($entity->url)->toBe('https://example.com/stream')
        ->and($entity->viewer_count)->toBe(1000);
});

test('can create KickStreamEntity from array', function () {
    $data = [
        'is_live' => true,
        'is_mature' => false,
        'key' => 'stream_key',
        'language' => 'en',
        'start_time' => '2023-01-01T12:00:00Z',
        'url' => 'https://example.com/stream',
        'viewer_count' => 1000,
    ];

    $entity = KickStreamEntity::fromArray($data);

    expect($entity->is_live)->toBeTrue()
        ->and($entity->is_mature)->toBeFalse()
        ->and($entity->key)->toBe('stream_key')
        ->and($entity->language)->toBe('en')
        ->and($entity->start_time)->toBe('2023-01-01T12:00:00Z')
        ->and($entity->url)->toBe('https://example.com/stream')
        ->and($entity->viewer_count)->toBe(1000);
});

test('can serialize KickStreamEntity to array', function () {
    $entity = new KickStreamEntity(
        is_live: true,
        is_mature: false,
        key: 'stream_key',
        language: 'en',
        start_time: '2023-01-01T12:00:00Z',
        url: 'https://example.com/stream',
        viewer_count: 1000
    );

    $serialized = $entity->jsonSerialize();

    expect($serialized)->toBe([
        'is_live' => true,
        'is_mature' => false,
        'key' => 'stream_key',
        'language' => 'en',
        'start_time' => '2023-01-01T12:00:00Z',
        'url' => 'https://example.com/stream',
        'viewer_count' => 1000,
        'thumbnail' => null,
        'custom_tags' => [],
    ]);
});
