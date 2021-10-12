<?php

namespace App\Providers;

use App\Models\Coupon;
use App\Models\User;
use App\Repositories\CouponRepository;

class CreateCouponAfterCheckout
{
    protected $couponRepository;

    private const COUPON_AMOUNT = 5.00;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CouponRepository $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    /**
     * Handle the event.
     *
     * @param  CheckoutCompleted $event
     * @return void
     */
    public function handle(CheckoutCompleted $event)
    {
        $coupon = $this->couponRepository->create('CP-POST-CHECKOUT', static::COUPON_AMOUNT);

        $this->scheduleNewCouponEmail($event->order->user, $coupon);
    }

    /**
     * @param User   $user
     * @param Coupon $coupon
     */
    private function scheduleNewCouponEmail(User $user, Coupon $coupon)
    {
    }
}
