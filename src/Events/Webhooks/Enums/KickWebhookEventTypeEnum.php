<?php

namespace DanielHe4rt\KickSDK\Events\Webhooks\Enums;

enum KickWebhookEventTypeEnum: string
{
    case ChatMessageSent = 'chat.message.sent';
    case ChannelFollowed = 'channel.followed';
    case ChannelSubscriptionRenewal = 'channel.subscription.renewal';
    case ChannelSubscriptionGifts = 'channel.subscription.gifts';
    case ChannelSubscriptionNew = 'channel.subscription.new';
    case LivestreamStatusUpdated = 'livestream.status.updated';

    case LivestreamMetadataUpdated = 'livestream.metadata.updated';
    case ModerationBanned = 'moderation.banned';

    /**
     * Get the event type from the header value
     */
    public static function fromHeader(?string $headerValue): ?self
    {
        if ($headerValue === null) {
            return null;
        }

        return self::tryFrom($headerValue);
    }
}
