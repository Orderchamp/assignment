<?php

namespace App\Domain\Exceptions;

use Exception;

class CannotApplyDiscountException extends Exception
{
    protected $message = 'Cannot apply discount because the reduced amount is less than 0.';

    public function __construct()
    {
        parent::__construct($this->message);
    }
}
