<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PedidoCocina implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels, Queueable;

    Public $userId, $Pedidos;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userid, $pedidos)
    {
        //
        $this->userId = $userid;
        $this->Pedidos = $pedidos;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("App.User." . $this->userId);
    }

    public function broadcastWith()
    {
        return ['PedidoCocina' => $this->Pedidos, "usuario" => $this->userId];
    }
}
