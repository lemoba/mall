<?php declare(strict_types=1);

namespace App\Service;

use App\Exception\BusinessException;
use App\Helper\CodeResponse;
use App\Model\User;

class UserService
{

    /**
     * 注册
     * @param  array  $input
     * @return void
     * @throws BusinessException
     */
    public function store(array $input)
    {
        if ($this->exists($input['mobile'])) {
            throw new BusinessException(CodeResponse::MOBILE_EXIEXTS);
        }
        $input['password'] = password_hash($input['password'], PASSWORD_DEFAULT);
        return User::create($input);
    }

    /**
     * 登录
     * @param  string  $mobile
     * @param  string  $password
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|object
     * @throws BusinessException
     */
    public function login(string $mobile, string $password)
    {
        $user = User::query()->where('mobile', $mobile)->first();

        if (!$user) {
            throw new BusinessException(CodeResponse::AUTH_INVALID_ACCOUNT);
        }

        if (!password_verify($password, $user->password)) {
            throw new BusinessException(CodeResponse::AUTH_INVALID_PASSWORD);
        }
        return $user;
    }

    /**
     * 获取用户信息
     * @param  int  $uid
     * @return \Hyperf\Database\Model\Model|null
     */
    public function userInfo(int $uid)
    {
        return User::query()->find($uid);
    }

    /**
     * 判断手机号是否存在
     * @param  string  $mobile
     * @return bool
     */
    protected function exists(string $mobile): bool
    {
        return User::query()->where('mobile', $mobile)->exists();
    }
}