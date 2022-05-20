<?php

declare(strict_types=1);

namespace App\Job;

use App\Enum\OrderEnum;
use App\Service\OrderService;
use Hyperf\AsyncQueue\Job;

class OrderTimerJob extends Job
{
    protected $id;

    public function __construct(int $order_id)
    {
        $this->id = $order_id;
    }

    public function handle()
    {
        di()->get(OrderService::class)->delTimeoutOrder($this->id, OrderEnum::TIME_OUT);
        // 通知用户订单已经取消
    }
}
