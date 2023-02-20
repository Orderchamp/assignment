<?php

namespace App\Jobs;

use App\Domain\DiscountCode\Services\DiscountCodeServiceInterface;
use App\Domain\Order\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateDiscountCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle(DiscountCodeServiceInterface $discountCodeService): void
    {
        $discountCodeService->generateDiscountCode($this->order, 5);
    }
}
