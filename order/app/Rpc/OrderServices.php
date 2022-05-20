<?php declare(strict_types=1);

namespace App\Rpc;

use App\Service\OrderService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\RpcServer\Annotation\RpcService;

/**
 * @RpcService(name="OrderServices", protocol="jsonrpc-http", server="jsonrpc-http", publishTo="consul")
 */
class OrderServices implements OrderServicesInterface
{
    /**
     * @Inject
     * @var OrderService
     */
    protected $orderService;

    public function list(int $uid, int $status = 0)
    {
        return $this->orderService->list($uid, $status);
    }

    public function detail(int $oid)
    {
        return $this->orderService->detail($oid);
    }

    public function create(array $data)
    {
        return $this->orderService->create($data);
    }

    public function update(int $oid, int $status)
    {
        return $this->orderService->update($oid, $status);
    }

    public function delete(int $oid)
    {
        return $this->orderService->delete($oid);
    }
}