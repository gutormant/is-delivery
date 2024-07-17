<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ParcelInfoFailSentEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ParcelInfoFailSentMailerListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ParcelInfoFailSentEvent $event): void
    {
        Log::alert(
            'ParcelInfoFailSentMailerListener handle '.$event->parcel->id.' with message '.$event->exception->getMessage(
            )
        );
    }
}
