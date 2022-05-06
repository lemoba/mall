<?php declare(strict_types=1);

namespace App\Controller;

use App\Helper\CodeResponse;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class BaseController extends AbstractController
{
    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    protected $validator;

    protected function codeReturn(array $codeResponse, $data = null, $info = '')
    {
        [$code, $msg] = $codeResponse;

        $res = ['code' => $code, 'msg' => $info ?: $msg];

        if (!is_null($data)) {
            if (is_array($data)) {
                $data = array_filter($data, function ($item) {
                    return $item != null;
                });
            }
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
            return $this->success($codeResponse, $data);
        } else {
            return $this->fail($codeResponse, $info);
        }
    }
}