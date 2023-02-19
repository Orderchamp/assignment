<?php

namespace App\Domain\Exceptions;

use Exception;

class ProductOutOfStockException extends Exception
{
    protected $message = 'The product is out of stock.';

    public function __construct()
    {
        parent::__construct($this->message);
    }
}
