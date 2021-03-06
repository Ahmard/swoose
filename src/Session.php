<?php


namespace Swoose;


use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class Session
{
    protected CacheItemInterface $cacheItem;


    /**
     * Session constructor.
     * @param AdapterInterface $adapter
     * @param string $sessionId
     * @throws InvalidArgumentException
     */
    public function __construct(
        protected AdapterInterface $adapter,
        protected string $sessionId,
    )
    {
        $this->cacheItem = $this->adapter->getItem($this->sessionId);
    }

    public function put(string $key, mixed $data): void
    {
        $saved = $this->getAll();
        $saved[$key] = $data;
        $this->saveItem($saved);
    }

    public function get(string $key): mixed
    {
        $data = $this->cacheItem->get();
        if (empty($data)) return null;
        return $data[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->getAll());
    }

    public function remove(string $key): void
    {
        $data = $this->getAll();
        unset($data[$key]);
        $this->saveItem($data);
    }

    protected function saveItem(array $data): void
    {
        $this->cacheItem->set($data);
        $this->adapter->save($this->cacheItem);
        $this->adapter->commit();
    }

    public function getAll(): array
    {
        $data = $this->cacheItem->get();
        return $data == null ? [] : $data;
    }
}