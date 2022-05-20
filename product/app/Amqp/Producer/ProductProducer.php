<?php

declare(strict_types=1);

namespace App\Amqp\Producer;

use Hyperf\Amqp\Annotation\Producer;
use Hyperf\Amqp\Message\ProducerMessage;

/**
 * @Producer(exchange="ProdcutSerivce", routingKey="product")
 */
class ProductProducer extends ProducerMessage
{
    public function __construct($data)
    {
        $this->payload = $data;
    }
}
