<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EnviarNotificacion implements ShouldBroadcast
{
    use Queueable, Dispatchable, InteractsWithSockets, SerializesModels;
    public $userId;
    public $notification;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $notification)
    {
        //
        $this->userId = $user;
        $this->notification = $notification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("App.User." . $this->userId);
    }
    public function broadcastWith()
    {
        return ['notificacion' => $this->notification,"usuario"=>$this->userId];
    }
}
