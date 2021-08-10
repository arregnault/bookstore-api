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

class NewBookEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
       * The user who generates the event.
       */
    public $user;
    
    /**
    * The book published
    */
    public $book;
    
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
    * The id of book published
    */
    public $book_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($book, $emails)
    {
        $this->user = Auth::user();
        $this->book = $book;
        $this->book_id = $book->id;
        $this->emails = $emails;
        $this->type = 'Publicación';
        $this->description = 'Un libro nuevo ha sido publicado.';
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
