<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\ParcelInfoFailSentEvent;
use App\Events\ParcelInfoSuccessSentEvent;
use App\Exceptions\UnknownDeliveryServiceException;
use App\Http\Requests\ParcelInfoSendRequest;
use App\Models\Parcel;
use App\Models\User;
use App\ParcelInfoStatus;
use App\Services\ParcelInfoSenders\AbstractDeliveryService;
use App\Services\ParcelInfoSenders\NovaPostDeliveryService;
use App\Services\ParcelInfoSenders\ParcelInfoSendInterface;
use Illuminate\Support\Facades\Log;

class ParcelInfoService
{

    /**
     * Create or update user with parcel
     * @param  ParcelInfoSendRequest  $request
     * @return Parcel
     */
    public function create(ParcelInfoSendRequest $request): Parcel
    {
        $user = User::query()->where('email', $request->email)->first();

        if ($user) {
            $user->update(
                [
                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name,
                    'last_name' => $request->last_name,
                    'name' => sprintf('%s %s %s', $request->first_name, $request->middle_name, $request->last_name),
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]
            );
        } else {
            $user = User::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'name' => sprintf('%s %s %s', $request->first_name, $request->middle_name, $request->last_name),
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        }

        $parcel = Parcel::create([
            'user_id' => $user->id,
            'width' => $request->width,
            'height' => $request->height,
            'depth' => $request->depth,
            'weight' => $request->weight,
        ]);

        return $parcel;
    }

    /**
     * @param  Parcel  $parcel
     * @return void
     */
    public function send(Parcel $parcel)
    {
        try {
            $sender = DeliveryCreatorService::getDeliveryService($parcel);

            if (!($sender instanceof ParcelInfoSendInterface)) {
                throw new UnknownDeliveryServiceException("Unknown delivery service with type {$parcel->service}");
            }

            $sender->sendParcelInfoRequest($parcel);
            $parcel->update(['status' => ParcelInfoStatus::SENT]);

            ParcelInfoSuccessSentEvent::dispatch($parcel);
        } catch (\Exception $e) {
            $parcel->update(['status' => ParcelInfoStatus::FAILED]);
            ParcelInfoFailSentEvent::dispatch($parcel, $e);
        }
    }
}
