<?php

namespace App\Taxes;

class Detector
{
    protected int $amount;

    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    public function detect(int $price): bool
    {
        if($this->amount>$price)
        {
            return true;
        }
            return false;
    }
}