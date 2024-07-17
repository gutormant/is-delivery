<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\UnknownDeliveryServiceException;
use App\Models\Parcel;
use App\Services\ParcelInfoSenders\AbstractDeliveryService;
use App\Services\ParcelInfoSenders\NovaPostDeliveryService;

class DeliveryCreatorService
{

    private static array $services = [
        NovaPostDeliveryService::class
    ];

    public static function getDeliveryService(Parcel $parcel): AbstractDeliveryService
    {
        foreach (self::$services as $service) {
            $serviceObject = $service::isDeliveryService($parcel->service);

            if ($serviceObject instanceof AbstractDeliveryService) {
                return $serviceObject;
            }
        }

        throw new UnknownDeliveryServiceException("Unknown delivery service with type {$parcel->service}");
    }
}
