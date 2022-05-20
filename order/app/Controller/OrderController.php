<?php declare(strict_types=1);

namespace App\Controller;

use App\Exception\BusinessException;
use App\Helper\CodeResponse;
use App\Rpc\ProductServicesInterface;
use App\Service\OrderService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PatchMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

#[Controller(prefix: '/api/v1')]
class OrderController extends BaseController
{
    #[Inject]
    protected OrderService $orderService;

    #[Inject]
    protected ProductServicesInterface $productService;

    #[GetMapping(path: 'orders')]
    public function index(RequestInterface $request)
    {
        $uid = $request->input('uid', 0);
        $status = $request->input('status', 0);
        if (!$uid) {
            throw new BusinessException(CodeResponse::PARMA_VALUE_ILLEGAL, 'uid is required');
        }
        $res = $this->orderService->list((int)$uid, (int)$status);
        return $this->success($res);
    }

    #[PostMapping(path: 'orders')]
    public function store(RequestInterface $request)
    {
        $input = $request->all();

        $validator = $this->validator->make($input, [
            'uid' => 'required',
            'pid' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            throw new BusinessException(CodeResponse::PARMA_VALUE_ILLEGAL);
        }

        $product = $this->productService->detail((int)$input['pid']);

        if (!$product) {
            throw new BusinessException(CodeResponse::PARMA_VALUE_ILLEGAL, 'pid not exsists');
        }
       $res = $this->orderService->create($input);
       return $this->failOrSuceess($res);
    }

    #[GetMapping(path: 'orders/{id:\d+}')]
    public function show(int $id)
    {
        $info = $this->orderService->detail($id);
        return $this->success($info);
    }

    #[PatchMapping(path: 'orders')]
    public function update(RequestInterface $request)
    {
        $status = $request->input('status');
        $oid = $request->input('oid');
        if (!$status || !$oid) {
            throw new BusinessException(CodeResponse::PARMA_VALUE_ILLEGAL, 'status or oid is requied');
        }
        $res = $this->orderService->update((int)$oid, (int)$status);

        return $this->failOrSuceess($res);
    }

    #[DeleteMapping(path: 'orders/{id:\d+}')]
    public function delete(int $id)
    {
        $res = $this->orderService->delete($id);
        return $this->failOrSuceess($res);
    }
}