<?php declare(strict_types=1);

namespace App\Controller;

use App\Helper\CodeResponse;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class BaseController extends AbstractController
{
    #[Inject]
    protected ValidatorFactoryInterface $validator;

    protected $redis;
    public function __construct()
    {
        $this->redis = di()->get(Redis::class);
    }

    protected function codeReturn(array $codeResponse, $data = null, $info = '')
    {
        [$err_no, $err_msg] = $codeResponse;

        $res = ['code' => $err_no, 'msg' => $info ?: $err_msg];

        if ($data !== null) {
            $res['data'] = $data;
        }

        return $this->response->json($res);
    }

    protected function success($data = null)
    {
        return $this->codeReturn(CodeResponse::SUCCESS, $data);
    }

    protected function message(array $codeResponse = CodeResponse::SUCCESS)
    {
        return $this->codeReturn($codeResponse);
    }

    protected function fail(array $codeResponse = CodeResponse::FAIL, $info = '')
    {
        return $this->codeReturn($codeResponse, null, $info);
    }

    protected function failOrSuceess($isSuccess, array $codeResponse = CodeResponse::SUCCESS, $data = null, $info = '')
    {
        if ($isSuccess) {
            return $this->success($data);
        } else {
            return $this->fail($codeResponse, $info);
        }
    }
}