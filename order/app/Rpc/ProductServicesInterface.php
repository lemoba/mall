<?php

namespace App\Rpc;

interface ProductServicesInterface
{
    public function list(int $status);

    public function detail(int $uid);

    public function create(array $data);

    public function update(int $pid, array $data);

    public function delete(int $pid);
}