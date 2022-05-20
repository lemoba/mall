<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\BusinessException;
use App\Helper\CodeResponse;
use App\Middleware\AuthMiddelware;
use App\Service\UserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Phper666\JWTAuth\JWT;
use Phper666\JWTAuth\Middleware\JWTAuthDefaultSceneMiddleware;
use Qbhy\HyperfAuth\AuthManager;

/**
 * @Controller(prefix="/api/user")
 */
class UserController extends BaseController
{

    /**
     * @Inject()
     * @var UserService
     */
    protected $userService;

    /**
     * @Inject()
     * @var AuthManager
     */
    protected $auth;

    /**
     * @PostMapping(path="register")
     */
    public function register(RequestInterface $request)
    {
        $input = $request->all();
        $validator = $this->validator->make(
            $input,
            [
                'name' => 'required',
                'gender' => 'required|min:0|max:2',
                'mobile' => 'required|min:11|max:11',
                'password' => 'required',
            ]
        );
        if ($validator->fails()) {
            throw new BusinessException(CodeResponse::PARMA_VALUE_ILLEGAL);
        }

        $res = $this->userService->store($input);
        return $this->failOrSuceess($res);
    }

    /**
     * @PostMapping(path="login")
     */
    public function login(RequestInterface $request)
    {
        $mobile = $request->input('mobile');
        $password = $request->input('password');

        $validator = $this->validator->make([
            'mobile' => $mobile,
            'password' => $password
        ], [
            'mobile' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            throw new BusinessException(CodeResponse::PARMA_VALUE_ILLEGAL);
        }

        $user =  $this->userService->login($mobile, $password);

        $token = $this->auth->login($user);

        return $this->success([
            'token' => $token,
            'userInfo' => $user
        ]);
    }

    /**
     * @GetMapping(path="userInfo")
     * @Middleware(AuthMiddelware::class)
     */
    public function userInfo()
    {
        return $this->success($this->auth->user());
    }

    /**
     * @PostMapping(path="logout")
     * @Middleware(AuthMiddelware::class)
     */
    public function logout()
    {
        return $this->failOrSuceess($this->auth->logout());
    }
}
