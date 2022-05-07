<?php declare(strict_types=1);

namespace App\Rpc;

use App\Service\UserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\RpcServer\Annotation\RpcService;

/**
 * @RpcService(name="UserServices", protocol="jsonrpc-http", server="jsonrpc-http", publishTo="consul")
 */
class UserServices implements UserServicesInterface
{
    /**
     * @Inject()
     * @var UserService
     */
    protected $userInfoService;

    public function userInfo(int $uid)
    {
        return $this->userInfoService->userInfo($uid);
    }
}