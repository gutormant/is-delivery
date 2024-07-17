<?php

declare(strict_types=1);

namespace App\Services\ParcelInfoSenders;

use App\Models\Parcel;

interface ParcelInfoSendInterface
{
    public function sendParcelInfoRequest(Parcel $parcel): true;
}
