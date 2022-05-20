<?php declare(strict_types=1);

namespace App\Rpc;

use App\Service\ProductService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\RpcServer\Annotation\RpcService;

/**
 * @RpcService(name="ProductServices", protocol="jsonrpc-http", server="jsonrpc-http", publishTo="consul")
 */
class ProductServices implements ProductServicesInterface
{
    /**
     * @Inject
     * @var ProductService
     */
    protected $productService;

    public function list(int $status = 0)
    {
        return $this->productService->list($status);
    }

    public function detail(int $pid)
    {
        return $this->productService->detail($pid);
    }

    public function create(array $data)
    {
        return $this->productService->create($data);
    }

    public function update(int $pid, array $data)
    {
        return $this->productService($pid, $data);
    }

    public function delete(int $pid)
    {
        return $this->productService->delete($pid);
    }
}