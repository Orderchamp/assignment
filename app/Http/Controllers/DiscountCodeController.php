<?php

namespace App\Http\Controllers;

use App\Domain\DiscountCode\Services\DiscountCodeServiceInterface;
use App\Http\Requests\ApplyDiscountCodeRequest;
use Illuminate\Http\JsonResponse;

class DiscountCodeController
{
    private DiscountCodeServiceInterface $discountCodeService;

    public function __construct(DiscountCodeServiceInterface $discountCodeService)
    {
        $this->discountCodeService = $discountCodeService;
    }

    public function apply(ApplyDiscountCodeRequest $request): JsonResponse
    {
        if ($this->discountCodeService->validateDiscountCode($request->input('discount_code'))) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
