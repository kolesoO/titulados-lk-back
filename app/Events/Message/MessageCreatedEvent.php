<?php

declare(strict_types=1);

namespace App\Events\Message;

use App\Concerns\Events\HasData;
use App\Jobs\BroadcastingEvent;
use Illuminate\Broadcasting\PrivateChannel;

class MessageCreatedEvent extends BroadcastingEvent
{
    use HasData;

    private int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /** @inheritDoc */
    public function broadcastAs(): string
    {
        return 'message_created';
    }

    /** @inheritDoc */
    public function broadcastOn()
    {
        return new PrivateChannel(
            config('channels.front') . $this->userId
        );
    }

    public function broadcastWith(): array
    {
        return $this->getFormattedAnswer(
            $this->getData()
        );
    }
}
