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

#[Controller(prefix: "/api/v1")]
class ProductController extends BaseController
{
    #[Inject]
    protected ProductService $productService;

    #[Inject]
    private EventDispatcherInterface $eventDispatcher;

    #[GetMapping(path: "product")]
    public function index()
    {
        $list = $this->productService->list();
        return $this->success($list);
    }

    #[GetMapping(path: "product/{id:\d+}")]
    public function show(int $id)
    {
        $product = $this->productService->detail($id);
        return $this->success($product);
    }

    #[PostMapping(path: "product")]
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

    #[PatchMapping(path: "product")]
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

    #[DeleteMapping(path: "product/{id: \d+}")]
    public function delete(int $id)
    {
        $res = $this->productService->delete($id);
        return $this->failOrSuceess($res);
    }
}