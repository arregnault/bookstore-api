<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class QueryBookEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user;
        
    /**
    * The event type.
    */
    public $type;
    
    /**
    * The description of the transaction
    */
    public $description;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = Auth::user();
        $this->type = 'Búsqueda de Libros';
        $this->description = 'Se ha realizado una o más consultas sobre Libros.';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
