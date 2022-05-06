<?php declare(strict_types=1);

namespace App\Service;

use App\Exception\BusinessException;
use App\Helper\CodeResponse;
use App\Model\User;

class UserService
{

    // 注册
    public function store(array $input)
    {
        if ($this->exists($input['mobile'])) {
            throw new BusinessException(CodeResponse::MOBILE_EXIEXTS);
        }
        $input['password'] = password_hash($input['password'], PASSWORD_DEFAULT);
        User::create($input);
    }


    // 登录
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

    protected function exists(string $mobile): bool
    {
        return User::query()->where('mobile', $mobile)->exists();
    }
}