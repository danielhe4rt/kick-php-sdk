<?php

namespace DanielHe4rt\KickSDK\Chat\DTOs;

use DanielHe4rt\KickSDK\Chat\KickMessageTypeEnum;
use InvalidArgumentException;
use JsonSerializable;

readonly class SendChatMessageDTO implements JsonSerializable
{
    /**
     * @param  int  $broadcaster_user_id  The ID of the broadcaster to send the message to
     * @param  string  $content  The message content (max 500 characters)
     * @param  KickMessageTypeEnum  $type  The message type (user or bot)
     * @param  string|null  $reply_to_message_id  UUID of the message to reply to
     */
    public function __construct(
        public int $broadcaster_user_id,
        public string $content,
        public KickMessageTypeEnum $type = KickMessageTypeEnum::User,
        public ?string $reply_to_message_id = null,
    ) {
        if (strlen($this->content) > 500) {
            throw new InvalidArgumentException('Message content cannot exceed 500 characters');
        }

        if (! in_array($this->type, KickMessageTypeEnum::cases(), true)) {
            throw new InvalidArgumentException('Invalid message type');
        }
    }

    /**
     * Create a new SendChatMessageDTO instance
     *
     * @param  int  $broadcaster_user_id  The ID of the broadcaster to send the message to
     * @param  string  $content  The message content (max 500 characters)
     * @param  KickMessageTypeEnum  $type  The message type (user or bot)
     * @param  string|null  $reply_to_message_id  UUID of the message to reply to
     */
    public static function make(
        int $broadcaster_user_id,
        string $content,
        KickMessageTypeEnum $type = KickMessageTypeEnum::User,
        ?string $reply_to_message_id = null,
    ): self {
        return new self(
            broadcaster_user_id: $broadcaster_user_id,
            content: $content,
            type: $type,
            reply_to_message_id: $reply_to_message_id,
        );
    }

    public function jsonSerialize(): array
    {
        $result = [
            'broadcaster_user_id' => $this->broadcaster_user_id,
            'content' => $this->content,
            'type' => $this->type->value,
        ];

        if ($this->reply_to_message_id !== null) {
            $result['reply_to_message_id'] = $this->reply_to_message_id;
        }

        return $result;
    }
}
