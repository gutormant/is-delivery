<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Parcel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ParcelInfoSuccessSentEvent
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Parcel $parcel)
    {
    }
}
