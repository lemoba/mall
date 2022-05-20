<?php

declare(strict_types=1);

namespace App\Listener;

use App\Amqp\Producer\ProductProducer;
use App\Event\ProductCreated;
use Hyperf\Amqp\Producer;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Event\Annotation\Listener;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;
use Swoole\Exception;

/**
 * @Listener
 */
#[Listener]
class ProductCreatedListener implements ListenerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @Inject
     * @var Producer
     */
    private $producer;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listen(): array
    {
        return [
            ProductCreated::class
        ];
    }

    public function process(object $event)
    {
        $message = new ProductProducer($event->product);
        try {
            $this->producer->produce($message);
        }catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
