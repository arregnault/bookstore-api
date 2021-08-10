<?php

namespace App\Listeners;

use App\Events\NewIdeasPromotionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use App\Mail\NewIdeasPromotionMail;

class NewIdeasPromotionMailFired
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
     * @param  NewIdeasPromotionEvent  $event
     * @return void
     */
    public function handle(NewIdeasPromotionEvent $event)
    {
        $author =  $event->author;
        $emails   =  $event->emails;

        Mail::to($emails)->send(new NewIdeasPromotionMail([
            'author' => $author,
        ]));
    }
}
