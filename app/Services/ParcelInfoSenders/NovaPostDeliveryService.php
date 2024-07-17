<?php

declare(strict_types=1);

namespace App\Services\ParcelInfoSenders;

use App\Exceptions\ParcelInfoSendingException;
use App\Models\Parcel;
use Illuminate\Support\Facades\Http;

class NovaPostDeliveryService extends AbstractDeliveryService implements ParcelInfoSendInterface
{
    protected const TYPE = 1;

    public function sendParcelInfoRequest(Parcel $parcel): true
    {
        $response = Http::post($this->getUrl(), $this->getPostDataFromParcel($parcel));

        if ($response->failed()) {
            throw new ParcelInfoSendingException('NovaPostDeliveryService error : '.$response->reason());
        }

        return true;
    }

    private function getUrl()
    {
        return 'http://127.0.0.1:8000/nova-post-receiver';
//        return config('deliveries.nova_post.host').config('deliveries.nova_post.urls.parcel_info_send');
    }

    private function getPostDataFromParcel(Parcel $parcel): array
    {
        return [
            'customer_name' => $parcel->user->first_name,
            'phone_number' => $parcel->user->phone,
            'email' => $parcel->user->email,
            'sender_address' => config('delivery.company.address'),
            'delivery_address' => $parcel->user->address,
        ];
    }
}
