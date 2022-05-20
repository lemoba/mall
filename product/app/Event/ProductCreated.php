<?php declare(strict_types=1);

namespace App\Event;

class ProductCreated
{
    public $product;

    public function __construct($product)
    {
        $this->product = $product;
    }
}