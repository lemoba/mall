<?php

namespace App\Rpc;

interface OrderServicesInterface
{
    public function list(int $uid, int $status = 0);

    public function detail(int $oid);

    public function create(array $data);

    public function update(int $oid, int $status);

    public function delete(int $oid);
}