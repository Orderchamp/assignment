<?php

namespace App\Providers;

use App\Mail\NewCouponEmail;
use App\Models\Coupon;
use App\Models\User;
use App\Repositories\CouponRepository;
use Illuminate\Support\Facades\Mail;

class CreateCouponAfterCheckout
{
    protected $couponRepository;

    private const EMAIL_DELAY_IN_MINUTES = 15;

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
        $time = now()->addMinutes(self::EMAIL_DELAY_IN_MINUTES);
        $mail = new NewCouponEmail($user, $coupon);

        // mail & queue setup needed in order for this to work
        Mail::to($user->email)->later($time, $mail);
    }
}
