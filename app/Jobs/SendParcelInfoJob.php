<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Parcel;
use App\Services\ParcelInfoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendParcelInfoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $maxExceptions = 3;

    public int $backoff = 5;

    public int $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(public Parcel $parcel)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(ParcelInfoService $parcelInfoSenderService): void
    {
        $parcelInfoSenderService->send($this->parcel);
    }
}
