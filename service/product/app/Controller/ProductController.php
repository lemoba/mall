<?php declare(strict_types=1);

namespace App\Controller;

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
        return $this->failOrSuceess($this->productService->create($params));
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
    public function delete()
    {
        return $this->success();
    }
}