<?php


namespace App\Service;

use Psr\Cache\CacheItemPoolInterface;

class RedisService
{
    /** @var CacheItemPoolInterface $cache */
    private $cache;

    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    public function getItem(string $key)
    {
        $item = $this->cache->getItem($key);
        if ($item->isHit()) {
            return $item->get();
        } else {
            return null;
        }
    }

    public function saveItem(string $key, $value, $expiration = null)
    {
        $item = $this->cache->getItem($key);

        if ($expiration) {
            $expired = new \DateTime();
            $expired->add(new \DateInterval('PT' . strval($expiration) . 'M'));
            $item->expiresAt($expired);
        }

        $item->set($value);
        $this->cache->save($item);
        $this->cache->commit();
    }

    public function removeItem(string $key)
    {
        if ($this->cache->hasItem($key)) {
            $this->cache->deleteItem($key);
            $this->cache->commit();
        }
    }
}