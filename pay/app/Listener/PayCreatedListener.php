<?php

declare(strict_types=1);

namespace App\Listener;

use App\Amqp\Producer\PayProducer;
use App\Event\PayCreated;
use Hyperf\Amqp\Producer;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * @Listener
 */
#[Listener]
class PayCreatedListener implements ListenerInterface
{

    #[Inject]
    protected Producer $producer;

    public function listen(): array
    {
        return [
            PayCreated::class
        ];
    }

    public function process(object $event)
    {
        $message = new PayProducer($event->pay);
        $this->producer->produce($message);
    }
}
