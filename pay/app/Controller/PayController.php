<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\BusinessException;
use App\Helper\CodeResponse;
use App\Rpc\OrderServicesInterface;
use App\Rpc\UserServicesInterface;
use App\Service\PayService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

#[Controller(prefix: "/api/v1")]
class PayController extends BaseController
{
    #[Inject]
    protected UserServicesInterface $userService;

    #[Inject]
    protected OrderServicesInterface $orderService;

    #[Inject]
    protected PayService $payService;

    #[PostMapping(path: "pay")]
    public function create(RequestInterface $request)
    {
        $input = $request->all();

        $validator = $this->validator->make($input, [
            'uid' => 'required',
            'oid' => 'required',
            'amount' => 'required',
            'source' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            throw new BusinessException(CodeResponse::PARMA_VALUE_ILLEGAL);
        }

        $user = $this->userService->userInfo((int)$input['uid']);

        $order = $this->orderService->detail((int)$input['oid']);

        if (!$user) {
            throw new BusinessException(CodeResponse::PARMA_VALUE_ILLEGAL, '用户不存在');
        }

        if (!$order) {
            throw new BusinessException(CodeResponse::PARMA_VALUE_ILLEGAL, '订单不存在');
        }

        $res = $this->payService->store($input);

        return $this->failOrSuceess($res);
    }

    #[GetMapping(path: "pay")]
    public function paymentCallBack()
    {

    }

    #[GetMapping("pay/{id: \d+}")]
    public function detail(int $id)
    {

    }
}
