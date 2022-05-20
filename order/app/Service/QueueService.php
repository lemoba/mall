<?php declare(strict_types=1);

namespace App\Service;

use App\Job\OrderTimerJob;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Driver\DriverInterface;

class QueueService
{
    protected DriverInterface $driver;

    public function __construct(DriverFactory $driverFactory)
    {
        $this->driver = $driverFactory->get('default');
    }

    public function cancel($params, int $delay = 1800): bool
    {
        return $this->driver->push(new OrderTimerJob($params), $delay);
    }
}