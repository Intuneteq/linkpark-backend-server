<?php

namespace App\Events\Models\User;

use App\Models\User;
use Faker\Core\Number;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GuardianCode
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $guardian_code;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, $guardianCode)
    {
        $this->user = $user;
        $this->guardian_code = $guardianCode;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
