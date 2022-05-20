<?php declare(strict_types=1);

namespace App\Helper;

class CodeResponse
{
    // 通用返回码
    const SUCCESS = [200, '成功'];
    const FAIL = [400, '错误'];
    const NO_LOGIN = [501, "请登录"];
    const UPDATED_FAIL = [505, "更新失败"];
    const PARMA_ILLEGAL = [401, '参数错误'];
    const PARMA_VALUE_ILLEGAL = [402, '参数值错误'];
    const MOBILE_EXIEXTS = [403, '手机号已存在'];

    // 业务返回码
    const MESSAGE_SUCCESS = [0, '短信发送成功'];
    const AUTH_INVALID_ACCOUNT = [700, '用户不存在'];
    const AUTH_CAPTCHA_DAILY_LIMT = [701, '频繁操作，请明天再试'];
    const AUTH_CAPTCHA_FREQUENCY = [702, '请2分钟后再试'];
    const AUTH_CAPTCHA_UNMATCH = [703, '验证码错误'];
    const AUTH_NAME_REGISTERED = [704, '用户已注册'];
    const AUTH_MOBILE_REGISTERED = [705, '手机号已注册'];
    const AUTH_MOBILE_UNREGISTERED = [706, '手机号未注册'];
    const AUTH_INVALID_MOBILE = [707, '手机号格式错误'];
    const AUTH_INVALID_PASSWORD = [708, '密码错误'];
}