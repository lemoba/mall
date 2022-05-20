<?php declare(strict_types=1);

namespace App\Repository;

class BaseRepository
{
    /**
     * 获取单例
     * @return @return static
     */
    public static function getInstance()
    {
        return di()->get(static::class);
    }

}