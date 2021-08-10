<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\BoughtBookEvent;
use App\Events\NewBookEvent;
use App\Events\NewIdeasPromotionEvent;
use App\Events\DestroyBookEvent;
use App\Events\LoginEvent;
use App\Events\QueryBookEvent;
use App\Events\UpdateBookEvent;


use App\Listeners\BoughtBookMailFired;
use App\Listeners\NewBookMailFired;
use App\Listeners\NewIdeasPromotionMailFired;
use App\Listeners\TransactionLog;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        BoughtBookEvent::class => [
            BoughtBookMailFired::class,
            TransactionLog::class,
        ],
        NewBookEvent::class => [
            NewBookMailFired::class,
            TransactionLog::class,
        ],
        NewIdeasPromotionEvent::class => [
            NewIdeasPromotionMailFired::class,
            TransactionLog::class,
        ],
        UpdateBookEvent::class => [
            TransactionLog::class,
        ],
        LoginEvent::class => [
            TransactionLog::class,
        ],
        QueryBookEvent::class => [
            TransactionLog::class,
        ],
        DestroyBookEvent::class => [
            TransactionLog::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
