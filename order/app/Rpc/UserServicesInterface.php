<?php declare(strict_types=1);

namespace App\Rpc;

interface UserServicesInterface
{
    public function userInfo(int $uid);
}