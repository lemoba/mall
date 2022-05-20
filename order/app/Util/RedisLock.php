<?php declare(strict_types=1);

namespace App\Util;

class RedisLock
{
    const VALUE_OF_LOCK = "locking";

    protected $key;
    protected $ttl;
    protected $redis;

    public function __construct($redis, string $key, int $ttl = 2000)
    {
        $this->redis = $redis;
        $this->key = $key;
        $this->ttl = $ttl;
    }

    public function acquire(): bool
    {
        $result = $this->redis->set($this->key, self::VALUE_OF_LOCK, 'PX', $this->ttl, 'NX');
        return $result == 1;
    }

    public function release()
    {
        $this->redis->del($this->key);
    }
}