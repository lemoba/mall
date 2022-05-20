<?php declare(strict_types=1);

namespace App\Controller;

use App\Exception\BusinessException;
use App\Helper\CodeResponse;
use App\Rpc\ProductServicesInterface;
use App\Service\OrderService;
use App\Util\RedisLock;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PatchMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Redis\RedisFactory;

#[Controller(prefix: '/api/order')]
class OrderController extends BaseController
{

    protected $redis;

    public function __construct(RedisFactory $redisFactory)
    {
        $this->redis = $redisFactory->get('default');
        parent::__construct();
    }

    #[Inject]
    protected OrderService $orderService;

    #[Inject]
    protected ProductServicesInterface $productService;

    #[GetMapping(path: 'list')]
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

    #[PostMapping(path: 'create')]
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

        $redis = new RedisLock($this->redis, 'lock');

        var_dump($redis->acquire());
        // $res = $this->orderService->create($input);
       return $this->success($product);
    }

    #[GetMapping(path: 'detail')]
    public function show(RequestInterface $request)
    {
        $oid = $request->input('oid', 0);

        if (!$oid) {
            throw new BusinessException(CodeResponse::PARMA_VALUE_ILLEGAL, 'order id is required');
        }
        $info = $this->orderService->detail((int)$oid);
        return $this->success($info);
    }

    #[PatchMapping(path: 'update')]
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

    #[DeleteMapping(path: 'delete')]
    public function delete(RequestInterface $request)
    {
        $oid = $request->input('o_id');
        if (!$oid) {
            throw new BusinessException(CodeResponse::PARMA_VALUE_ILLEGAL, 'o_id is requied');
        }
        $res = $this->orderService->delete($oid);

        return $this->failOrSuceess($res);
    }
}