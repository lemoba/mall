<?php declare(strict_types=1);

namespace App\Exception;

use Exception;

class BusinessException extends Exception
{
    public function __construct(array $codeResponse, $info = '')
    {
        [$code, $msg] = $codeResponse;
        parent::__construct($info ?: $msg, $code);
    }
}