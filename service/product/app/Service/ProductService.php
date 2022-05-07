<?php declare(strict_types=1);

namespace App\Service;

use App\Model\Product;

class ProductService
{

    public function list()
    {
        return Product::query()->where('status', 1)->get();
    }

    public function create(array $product)
    {
        return Product::query()->create($product);
    }

    public function detail(int $pid)
    {
        return Product::query()->find($pid);
    }

    public function update(int $pid, array $params)
    {
        $data = $this->formatInput($params, ['name', 'desc', 'stock', 'amount']);
        return Product::query()->where('id', $pid)
            ->update($data);
    }


    protected function formatInput(array $input, array $format): array
    {
        $output = array_filter(array_flip($input), function ($item) use ($format){
            return in_array($item, $format);
        });
        return array_flip($output);
    }
}