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

class BoughtBookEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
    * The user who generates the event.
    */
    public $user;
        
    /**
    * The book that was sold
    */
    public $book;
    
    /**
    * The author to notify.
    */
    public $author_email;
    /**
    * The event type.
    */
    public $type;
    
    /**
    * The description of the transaction
    */
    public $description;

    
    /**
    * The user_book_id ref of the sell
    */
    public $user_book_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($author, $book, $reservation)
    {
        $this->user = Auth::user();
        $this->book = $book;
        $this->user_book_id = $reservation->id;
        $this->author_email = $author->email;
        $this->type = 'Compra';
        $this->description = 'Se ha realizado la compra de un libro.';
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
