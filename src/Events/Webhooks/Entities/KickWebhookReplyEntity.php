<?php

namespace DanielHe4rt\KickSDK\Events\Webhooks\Entities;

use JsonSerializable;

readonly class KickWebhookReplyEntity implements JsonSerializable
{
    public function __construct(
        public string $messageId,
        public string $content,
        public KickWebhookUserEntity $sender,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            messageId: $data['message_id'],
            content: $data['content'],
            sender: KickWebhookUserEntity::fromArray($data['sender']),
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'message_id' => $this->messageId,
            'content' => $this->content,
            'sender' => $this->sender->jsonSerialize(),
        ];
    }
}
