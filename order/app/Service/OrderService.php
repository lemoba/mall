<?php declare(strict_types=1);

namespace App\Service;

use App\Enum\OrderEnum;
use App\Event\OrderCreated;
use App\Exception\BusinessException;
use App\Helper\CodeResponse;
use App\Model\Order;
use App\Rpc\UserServicesInterface;
use Hyperf\Di\Annotation\Inject;

class OrderService
{
    #[Inject]
    protected UserServicesInterface $userService;

    #[Inject]
    protected QueueService $queueService;

    public function list(int $uid, int $status = 0)
    {
        $list = Order::query()->where('uid', $uid)
            ->where('status', $status)
            ->get();
        return $list ?? [];
    }

    public function create(array $params)
    {
        $isUser = $this->isUser((int)$params['uid']);

        if (!$isUser) {
            throw new BusinessException(CodeResponse::AUTH_INVALID_ACCOUNT);
        }
        $res = Order::query()->create($params);
        $this->queueService->cancel($res->id, 10); // 投递异步任务 超时取消
        return $res;
    }

    public function detail(int $id)
    {
        return Order::query()->find($id) ?? [];
    }

    public function update(int $id, int $status)
    {
        return Order::query()->where('id', $id)->update(['status' => $status]);
    }

    public function delete(int $id)
    {
        return Order::query()->where('id', $id)->delete();
    }

    protected function isUser(int $uid): bool
    {
        $user = $this->userService->userInfo($uid);
        if ($user) return true;
        return false;
    }

    public function delTimeoutOrder(int $id, int $status)
    {
        $order = Order::query()->find($id);
        if ($order->status == OrderEnum::UNPAID) {
            $order->status = OrderEnum::TIME_OUT;
            $order->save();
        }
    }
}