<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\BusinessException;
use App\Helper\CodeResponse;
use App\Rpc\OrderServicesInterface;
use App\Rpc\UserServicesInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * @Controller(prefix="/api/pay")
 */
class PayController extends BaseController
{
    /**
     * @Inject
     * @var UserServicesInterface
     */
    protected $userService;

    /**
     * @Inject
     * @var OrderServicesInterface
     */
    protected $orderService;

    /**
     * @PostMapping(path="create")
     */
    public function create(RequestInterface $request)
    {
        $input = $request->all();

        $validator = $this->validator->make($input, [
            'uid' => 'required',
            'oid' => 'required',
            'amout' => 'required',
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


        return $this->success($order);
    }

    /**
     * @GetMapping(path="paymentCallBack")
     */
    public function paymentCallBack()
    {

    }

    /**
     * @GetMapping("detail")
     */
    public function detail(RequestInterface $request)
    {

    }
}
