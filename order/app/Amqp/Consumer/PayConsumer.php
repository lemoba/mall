<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Repository\OrderRepository;
use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\Di\Annotation\Inject;
use PhpAmqpLib\Message\AMQPMessage;

#[Consumer(exchange: 'exchange.pay.order', routingKey: 'key.order', queue: 'queue.pay.order', name: "PayConsumer", nums: 1)]
class PayConsumer extends ConsumerMessage
{
    #[Inject]
    protected OrderRepository $orderRepository;

    public function consumeMessage($data, AMQPMessage $message): string
    {
        $res = $this->orderRepository->updateById($data['oid'], ['status' => $data['status']]);
        return $res == 1 ? Result::ACK : Result::REQUEUE;
    }
}
