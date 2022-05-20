<?php

namespace App\Rpc;

interface PayServicesInterface
{
    public function create(int $uid, array $data);

    public function detail(int $uid, int $pid, int $status);
}