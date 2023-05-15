<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Auth\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use App\Http\Resources\Shop\MessageResource;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatEvents implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $user;
    public $sender;

    public function __construct($message, int $user, int $sender)
    {
        $this->message = $message;
        $this->user = $user;
        $this->sender = $sender;
    }


    public function broadcastAs()
    {
        return 'server.created';
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('sendToUser.' . $this->user),
            new PrivateChannel('sendToSender.' . $this->sender),
            new Channel('public'),
        ];
    }

    public function broadcastWith()
    {
        return [
            'sender' => $this->sender,
            'user' => $this->user,
            'message' => new MessageResource($this->message)
        ];
    }
}
