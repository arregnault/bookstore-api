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

class NewIdeasPromotionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
    * The user who generates the event.
    */
    public $user;
    
    /**
    * The author relatde to the event.
    */
    public $author;

    /**
    * The emails to notify.
    */
    public $emails;
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
    public function __construct($author, $emails)
    {
        $this->user = Auth::user();
        $this->author = $author;
        $this->emails = $emails;
        $this->type = 'Recaudación';
        $this->description = 'La promoción de ayuda a las nuevas ideas se ha completado.';
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
