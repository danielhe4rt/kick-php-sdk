# Kick PHP SDK - Release Notes

## Version 1.0.0 - Webhook Integration

We're excited to announce the release of the Kick PHP SDK with comprehensive webhook support! This release introduces a robust system for handling Kick.com webhooks, allowing developers to easily integrate real-time events from Kick into their PHP applications.

### New Features

#### Webhook Support

The SDK now provides complete webhook integration with Kick.com, supporting all current webhook event types:

- **Chat Events**
  - `chat.message.sent` - Receive real-time chat messages from your channel

- **Channel Events**
  - `channel.followed` - Get notified when someone follows your channel
  - `channel.subscription.new` - Receive notifications for new subscriptions
  - `channel.subscription.renewal` - Get notified when subscriptions are renewed
  - `channel.subscription.gifts` - Receive notifications for gifted subscriptions

- **Livestream Events**
  - `livestream.status.updated` - Get notified when a stream starts or ends

#### Webhook Components

- **Payload Classes**
  - `ChatMessageSentPayload` - Handle chat message events with sender, content, and emote data
  - `ChannelFollowedPayload` - Process follow events with follower information
  - `ChannelSubscriptionNewPayload` - Handle new subscription events
  - `ChannelSubscriptionRenewalPayload` - Process subscription renewal events
  - `ChannelSubscriptionGiftsPayload` - Handle gifted subscription events
  - `LivestreamStatusUpdatedPayload` - Process stream start/end events

- **Entity Classes**
  - `KickWebhookUserEntity` - Structured representation of Kick users in webhook payloads
  - `KickWebhookEmoteEntity` - Handle emotes in chat messages with position data

- **Webhook Processing**
  - `KickWebhookFactory` - Create appropriate payload objects from webhook request data
  - `KickWebhookVerifier` - Verify webhook signatures to ensure authenticity
  - `KickWebhookEventTypeEnum` - Enum for all supported webhook event types

#### Event Subscription Management

- **Event Subscription**
  - `KickEventsResource` - Manage webhook subscriptions (create, list, delete)
  - `EventSubscriptionDTO` - Data transfer object for event subscription details
  - `CreateEventSubscriptionDTO` - DTO for creating new event subscriptions

### Usage Examples

#### Receiving Webhooks

```php
// Create a webhook handler
$publicKey = 'your_kick_public_key';
$verifier = new KickWebhookVerifier($publicKey);

// Get the request data
$signature = $_SERVER['HTTP_KICK_SIGNATURE'] ?? '';
$payload = file_get_contents('php://input');
$headers = [
    'Kick-Event-Type' => $_SERVER['HTTP_KICK_EVENT_TYPE'] ?? null,
    'Kick-Event-Version' => $_SERVER['HTTP_KICK_EVENT_VERSION'] ?? null,
];

// Verify the webhook signature
if (!$verifier->verify($signature, $payload)) {
    http_response_code(401);
    exit('Invalid signature');
}

// Parse the payload
$data = json_decode($payload, true);
$webhookPayload = KickWebhookFactory::createFromRequest($headers, $data);

// Handle different event types
if ($webhookPayload instanceof ChatMessageSentPayload) {
    // Handle chat message
    $sender = $webhookPayload->sender;
    $message = $webhookPayload->content;
    // Process the chat message...
} elseif ($webhookPayload instanceof ChannelFollowedPayload) {
    // Handle new follower
    $follower = $webhookPayload->follower;
    // Process the new follower...
}
```

#### Managing Event Subscriptions

```php
// Initialize the Kick client
$client = new KickClient('your_client_id', 'your_client_secret');
$client->setAccessToken('your_access_token');

// Get the events resource
$eventsResource = $client->events();

// Create a new event subscription
$event = new EventSubscriptionDTO('chat.message.sent');
$subscription = new CreateEventSubscriptionDTO(
    'https://your-webhook-url.com/webhook',
    [$event]
);
$result = $eventsResource->createSubscription($subscription);

// List all event subscriptions
$subscriptions = $eventsResource->getSubscriptions();

// Delete an event subscription
$eventsResource->deleteSubscription('subscription_id');
```

### Comprehensive Testing

The SDK includes extensive test coverage for all webhook components:

- Unit tests for all payload types
- Tests for entity creation and serialization
- Tests for webhook verification
- Tests for event type handling
- Tests for webhook factory functionality

### Requirements

- PHP 8.1 or higher
- ext-json
- GuzzleHttp 7.0 or higher

### What's Next

We're continuously working to improve the SDK and add more features. Future updates will include:

- Support for additional Kick API endpoints
- Enhanced error handling and logging
- More comprehensive documentation
- Additional helper methods for common tasks

### Feedback and Contributions

We welcome feedback and contributions! Please submit issues and pull requests on our GitHub repository.

---

Thank you for using the Kick PHP SDK! We hope it makes integrating with Kick.com a seamless experience for your PHP applications. 