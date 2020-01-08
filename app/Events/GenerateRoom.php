<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\User;
use App\DuelRoom;

class GenerateRoom implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user1, $user2, $room;
    public $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($room)
    {
        // $this->user1 = $user1;
        // $this->user2 = $user2;
        $this->room = $room;
        // $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('duelroom'.$this->room->id);
        return ['duelqueue'];
    }

    
    public function broadcastAs()
    {
        return 'generateroom';
    }
}
