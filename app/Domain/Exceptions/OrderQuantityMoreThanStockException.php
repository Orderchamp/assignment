<?php

namespace App\Domain\Exceptions;

use Exception;

class OrderQuantityMoreThanStockException extends Exception
{
    public function __construct(int $cartItemQuantities, int $productQuantity)
    {
        parent::__construct(sprintf('The amount of products (%d) you\'re trying to add is more than our (%d) stock', $cartItemQuantities, $productQuantity));
    }
}
