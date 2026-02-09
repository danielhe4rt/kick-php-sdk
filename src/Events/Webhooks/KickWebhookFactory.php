<?php

namespace DanielHe4rt\KickSDK\Events\Webhooks;

use DanielHe4rt\KickSDK\Events\Webhooks\Enums\KickWebhookEventTypeEnum;
use DanielHe4rt\KickSDK\Events\Webhooks\Payloads\ChannelFollowedPayload;
use DanielHe4rt\KickSDK\Events\Webhooks\Payloads\ChannelRewardRedemptionUpdatedPayload;
use DanielHe4rt\KickSDK\Events\Webhooks\Payloads\ChannelSubscriptionGiftsPayload;
use DanielHe4rt\KickSDK\Events\Webhooks\Payloads\ChannelSubscriptionNewPayload;
use DanielHe4rt\KickSDK\Events\Webhooks\Payloads\ChannelSubscriptionRenewalPayload;
use DanielHe4rt\KickSDK\Events\Webhooks\Payloads\ChatMessageSentPayload;
use DanielHe4rt\KickSDK\Events\Webhooks\Payloads\KickWebhookPayload;
use DanielHe4rt\KickSDK\Events\Webhooks\Payloads\KicksGiftedPayload;
use DanielHe4rt\KickSDK\Events\Webhooks\Payloads\LivestreamMetadataUpdatedPayload;
use DanielHe4rt\KickSDK\Events\Webhooks\Payloads\LivestreamStatusUpdatedPayload;
use DanielHe4rt\KickSDK\Events\Webhooks\Payloads\ModerationBannedPayload;

class KickWebhookFactory
{
    /**
     * Create a webhook payload from the request data and headers
     *
     * @param  array  $data  The request body data
     * @param  array  $headers  The request headers
     */
    public static function createFromRequest(array $headers, array $data): ?KickWebhookPayload
    {
        $eventType = KickWebhookEventTypeEnum::fromHeader($headers['Kick-Event-Type'] ?? null);

        if ($eventType === null) {
            return null;
        }

        return match ($eventType) {
            KickWebhookEventTypeEnum::ChatMessageSent => ChatMessageSentPayload::fromRequest($headers, $data),
            KickWebhookEventTypeEnum::ChannelFollowed => ChannelFollowedPayload::fromRequest($headers, $data),
            KickWebhookEventTypeEnum::ChannelSubscriptionRenewal => ChannelSubscriptionRenewalPayload::fromRequest($headers, $data),
            KickWebhookEventTypeEnum::ChannelSubscriptionGifts => ChannelSubscriptionGiftsPayload::fromRequest($headers, $data),
            KickWebhookEventTypeEnum::ChannelSubscriptionNew => ChannelSubscriptionNewPayload::fromRequest($headers, $data),
            KickWebhookEventTypeEnum::LivestreamStatusUpdated => LivestreamStatusUpdatedPayload::fromRequest($headers, $data),
            KickWebhookEventTypeEnum::LivestreamMetadataUpdated => LivestreamMetadataUpdatedPayload::fromRequest($headers, $data),
            KickWebhookEventTypeEnum::ModerationBanned => ModerationBannedPayload::fromRequest($headers, $data),
            KickWebhookEventTypeEnum::ChannelRewardRedemptionUpdated => ChannelRewardRedemptionUpdatedPayload::fromRequest($headers, $data),
            KickWebhookEventTypeEnum::KicksGifted => KicksGiftedPayload::fromRequest($headers, $data),
        };
    }
}
