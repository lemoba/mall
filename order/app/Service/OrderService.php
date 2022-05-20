<?php declare(strict_types=1);

namespace App\Service;

use App\Exception\BusinessException;
use App\Helper\CodeResponse;
use App\Model\Order;
use App\Rpc\UserServicesInterface;
use Hyperf\Di\Annotation\Inject;

class OrderService
{
    /**
     * @Inject
     * @var UserServicesInterface
     */
    private $userService;

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
        return Order::query()->create($params);
    }

    public function detail(int $oid)
    {
        return Order::query()->find($oid) ?? [];
    }

    public function update(int $oid, int $status)
    {
        return Order::find($oid)->update(['status' => $status]);
    }

    public function delete(int $oid)
    {
        return Order::find($oid)->delete();
    }

    protected function isUser(int $uid): bool
    {
        $user = $this->userService->userInfo($uid);
        if ($user) return true;
        return false;
    }
}