<?php declare(strict_types=1);

namespace App\Controller;

use App\Event\ProductCreated;
use App\Exception\BusinessException;
use App\Helper\CodeResponse;
use App\Service\ProductService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PatchMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * @Controller(prefix="/api/product")
 */
class ProductController extends BaseController
{
    /**
     * @Inject
     * @var ProductService
     */
    protected $productService;


    /**
     * @Inject
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @GetMapping(path="list")
     */
    public function index()
    {
        $list = $this->productService->list();
        return $this->success($list);
    }

    /**
     * @GetMapping(path="detail")
     */
    public function show(RequestInterface $request)
    {
        $pid = $request->input('id', 0);

        if (!$pid) {
            throw new BusinessException(CodeResponse::PARMA_VALUE_ILLEGAL, 'id is required');
        }

        $product = $this->productService->detail((int)$pid);

        return $this->success($product);
    }

    /**
     * @PostMapping(path="create")
     */
    public function store(RequestInterface $request)
    {
        $params = $request->all();

        $validator = $this->validator->make($params, [
           'name' => 'required',
           'desc' => 'required',
           'stock' => 'required',
           'amount' => 'required',
        ]);

        if ($validator->fails()) {
            throw new BusinessException(CodeResponse::PARMA_VALUE_ILLEGAL, $validator->errors()->first());
        }

        $res = $this->productService->create($params);

        if ($res) {
            $this->eventDispatcher->dispatch(new ProductCreated($res->toArray()));
        }

        return $this->failOrSuceess($res);
    }

    /**
     * @PatchMapping(path="update")
     */
    public function update(RequestInterface $request)
    {
        $params = $request->all();
        $pid = $request->input('pid', 0);

        if (!$pid) {
            throw new BusinessException(CodeResponse::PARMA_VALUE_ILLEGAL, 'pid is required');
        }
        $res = $this->productService->update((int)$pid, $params);
        return $this->failOrSuceess($res);
    }

    /**
     * @DeleteMapping(path="delete")
     */
    public function delete(RequestInterface $request)
    {
        $pid = $request->input('pid', 0);
        if (!$pid) {
            throw new BusinessException(CodeResponse::PARMA_VALUE_ILLEGAL, 'pid is required');
        }
        $res = $this->productService->delete((int)$pid);
        return $this->failOrSuceess($res);
    }
}