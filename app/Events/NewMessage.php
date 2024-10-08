<?php

namespace App\Events;

use App\Model\Participant\ParticipantGroupDiscuss;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversation;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ParticipantGroupDiscuss $conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new Channel('bcsaa');
        return new PrivateChannel('group.'.$this->conversation->group_no);
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->conversation->message,
            'file'    => $this->conversation->file,  
            'user' => [
                'id' => $this->conversation->user->id,
                'name' => $this->conversation->user->name,
            ]
        ];
    }
}
