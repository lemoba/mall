<?php declare(strict_types=1);

namespace App\Repository;

use App\Model\Order;

class OrderRepository
{
    public function updateById(int $order_id, array $update=['*'])
    {
        return Order::query()->where('id', $order_id)->update($update);
    }
}