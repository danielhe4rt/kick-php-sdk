<?php

namespace DanielHe4rt\KickSDK\OAuth\Enums;

/**
 * Scopes for Kick API

 *
 * @see https://docs.kick.com/getting-started/scopes
 */
enum KickOAuthScopesEnum: string
{
    /**
     * @scope user:read
     *
     * @summary Read user info
     *
     * @description View user information in Kick including username, streamer ID, etc.
     */
    case USER_READ = 'user:read';

    /**
     * @scope channel:read
     *
     * @summary Read channel info
     *
     * @description View channel information in Kick including channel description, category, etc.
     */
    case CHANNEL_READ = 'channel:read';

    /**
     * @scope channel:write
     *
     * @summary Update channel info
     *
     * @description Update livestream metadata for a channel based on the channel ID.
     */
    case CHANNEL_WRITE = 'channel:write';

    /**
     * @scope chat:write
     *
     * @summary Write to chat
     *
     * @description Send chat messages and allow chatbots to post in your chat.
     */
    case CHAT_WRITE = 'chat:write';

    /**
     * @scope streamkey:read
     *
     * @summary Read stream key
     *
     * @description Read a user's stream URL and stream key.
     */
    case STREAMKEY_READ = 'streamkey:read';

    /**
     * @scope events:subscribe
     *
     * @summary Subscribe to events
     *
     * @description Subscribe to all channel events on Kick e.g. chat messages, follows, subscriptions.
     */
    case EVENTS_SUBSCRIBE = 'events:subscribe';

    /**
     * @scope events:read
     *
     * @summary Read event subscriptions
     *
     * @description Read event subscriptions for your application.
     */
    case EVENTS_READ = 'events:read';

    /**
     * @scope events:write
     *
     * @summary Manage event subscriptions
     *
     * @description Create and delete event subscriptions for your application.
     */
    case EVENTS_WRITE = 'events:write';

    /**
     * @scope moderation:ban
     *
     * @summary Ban/unban users
     *
     * @description Ban, timeout, and unban users in a channel.
     */
    case MODERATION_BAN = 'moderation:ban';

    /**
     * @scope moderation:chat_message:manage
     *
     * @summary Moderate chat messages
     *
     * @description Delete chat messages in a channel.
     */
    case MODERATION_CHAT_MESSAGE_MANAGE = 'moderation:chat_message:manage';

    /**
     * @scope channel:rewards:read
     *
     * @summary View channel point rewards
     *
     * @description View channel point rewards and redemptions.
     */
    case CHANNEL_REWARDS_READ = 'channel:rewards:read';

    /**
     * @scope channel:rewards:write
     *
     * @summary Manage channel point rewards
     *
     * @description Create, update, and delete channel point rewards. Accept or reject redemptions.
     */
    case CHANNEL_REWARDS_WRITE = 'channel:rewards:write';

    /**
     * @scope kicks:read
     *
     * @summary View KICKs leaderboard
     *
     * @description View KICKs leaderboard information.
     */
    case KICKS_READ = 'kicks:read';
}
