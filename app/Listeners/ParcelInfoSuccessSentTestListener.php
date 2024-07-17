<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ParcelInfoSuccessSentEvent;
use Illuminate\Support\Facades\Log;

class ParcelInfoSuccessSentTestListener
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
    public function handle(ParcelInfoSuccessSentEvent $event): void
    {
        Log::alert('ParcelInfoSuccessSentTestListener handle ' . $event->parcel->id);
    }
}
