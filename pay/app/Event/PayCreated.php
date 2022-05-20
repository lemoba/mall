<?php declare(strict_types=1);

namespace App\Event;

class PayCreated
{
    public $pay;

    public function __construct($pay)
    {
        $this->pay = $pay;
    }
}