<?php declare(strict_types=1);

namespace App\Service;

use App\Event\PayCreated;
use App\Model\Pay;
use Hyperf\Di\Annotation\Inject;
use Psr\EventDispatcher\EventDispatcherInterface;

class PayService
{
    #[Inject]
    private EventDispatcherInterface $eventDispatcher;

    public function store(array $params)
    {
        $res = Pay::query()->create($params);
        $this->eventDispatcher->dispatch(new PayCreated($res));
        return $res;
    }
}