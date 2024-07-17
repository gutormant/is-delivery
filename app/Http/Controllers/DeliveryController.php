<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ParcelInfoSendRequest;
use App\Jobs\SendParcelInfoJob;
use App\Services\ParcelInfoService;

class DeliveryController extends Controller
{

    public function send(ParcelInfoSendRequest $request, ParcelInfoService $parcelInfoSenderService)
    {
        SendParcelInfoJob::dispatch($parcelInfoSenderService->create($request));

        return response('Ok');
    }
}
