<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\TransactionLog as TransactionLogRepository;

class TransactionLog
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // $type         = $event->type;
        // $user         = $event->user;
        // $user_book_id = $event->user_book_id ?? null;
        // $book_id      = $event->book_id      ?? null;
        // $author_id    = $event->author_id    ?? null;
        // $description  = $event->description;

        // $log = TransactionLogRepository::create(
        //     [
        //         'type'          => $type,
        //         'description'   => $description,
        //         'user_book_id'  => $user_book_id,
        //         'book_id'       => $book_id,
        //         'author_id'     => $author_id,
        //         'user_id'       => $user->id,
        //     ]
        // );
 
        // return $log;
    }
}
