<?php declare(strict_types=1);

use App\Rpc\OrderServicesInterface;
use App\Rpc\UserServicesInterface;

return [
    // 此处省略了其它同层级的配置
    'consumers' => [
        [
            'name' => 'UserServices',
            'service' => UserServicesInterface::class,
            'registry' => [
                'protocol' => 'consul',
                'address' => 'http://127.0.0.1:8500',
            ],
        ],
        [
            'name' => 'OrderServices',
            'service' => OrderServicesInterface::class,
            'registry' => [
                'protocol' => 'consul',
                'address' => 'http://127.0.0.1:8500',
            ],
        ],
        [
            'name' => 'UserServices',
            'service' => UserServicesInterface::class,
            'registry' => [
                'protocol' => 'consul',
                'address' => 'http://127.0.0.1:8500',
            ],
        ],
    ],
];