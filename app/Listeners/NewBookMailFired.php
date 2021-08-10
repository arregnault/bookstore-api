<?php

namespace App\Listeners;

use App\Events\NewBookEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use App\Mail\NewBookMail;

class NewBookMailFired
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
     * @param  NewBookEvent  $event
     * @return void
     */
    public function handle(NewBookEvent $event)
    {
        $user =  $event->user;
        $book   =  $event->book;
        $emails   =  $event->emails;

        Mail::to($emails)->queue(new NewBookMail([
            'author' => $user,
            'book' => $book,
        ]));
    }
}
