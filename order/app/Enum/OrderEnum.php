<?php

declare(strict_types=1);

namespace App\Enum;

use Hyperf\Constants\AbstractConstants;


class OrderEnum
{
    const UNPAID = 0;
    const PIAD = 1;
    const CANCEL = 2;
    const TIME_OUT = 3;
    const FAIL = 3;
}
