<?php

declare(strict_types=1);

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

abstract class BroadcastingEvent implements ShouldBroadcast
{
    use SerializesModels;

    protected ?string $uuid = null;

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    protected function getFormattedAnswer(array $data = []): array
    {
        return [
            'event' => $this->broadcastAs(),
            'date'  => Carbon::now()->format("Ymd") . "T" . Carbon::now()->format("H:i:sP"),
            'uuid'  => $this->uuid,
            "data"  => $data,
        ];
    }

    /**
     * @return string
     */
    abstract public function broadcastAs(): string;
}
