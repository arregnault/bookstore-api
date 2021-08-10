<?php

namespace App\Listeners;

use App\Events\BoughtBookEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use App\Mail\BoughtBookMail;

class BoughtBookMailFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BoughtBookEvent  $event
     * @return void
     */
    public function handle(BoughtBookEvent $event)
    {
        $user           =  $event->user;
        $book           =  $event->book;
        $author_email   =  $event->author_email;

        Mail::to($author_email)->send(new BoughtBookMail([
            'user' => $user,
            'book' => $book,
        ]));
    }
}
