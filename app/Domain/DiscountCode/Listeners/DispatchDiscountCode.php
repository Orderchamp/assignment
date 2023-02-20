<?php

namespace App\Domain\DiscountCode\Listeners;

use App\Domain\Order\Events\OrderCreated;
use App\Jobs\CreateDiscountCode;

class DispatchDiscountCode
{
    public function handle(OrderCreated $event): void
    {
        CreateDiscountCode::dispatch($event->order)->delay(now()->addMinutes(15));
    }
}
