<?php declare(strict_types=1);

namespace App\Common;

use Hyperf\Logger\LoggerFactory;

class Log
{
    public static function channel(string $channel='default')
    {
        return self::getInstance($channel);
    }

    private static function getInstance($channel, string $name = 'app')
    {
        return di()->get(LoggerFactory::class)->get($name, $channel);
    }

    public static function __callStatic($func, $args)
    {
        self::channel()->$func(...$args);
    }
}