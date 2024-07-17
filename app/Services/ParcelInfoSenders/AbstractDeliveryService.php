<?php

declare(strict_types=1);

namespace App\Services\ParcelInfoSenders;

abstract class AbstractDeliveryService
{
    protected const TYPE = 0;

    public static function isDeliveryService(int $type): ?static
    {
        if ($type === static::TYPE) {
            return new static();
        }

        return null;
    }
}
