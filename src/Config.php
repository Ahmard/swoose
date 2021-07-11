<?php


namespace Swoose;


use JetBrains\PhpStorm\Pure;
use Symfony\Contracts\Cache\CacheInterface;

class Config
{
    protected CacheInterface $cache;


    #[Pure] public static function create(): static
    {
        return new static();
    }

    public function cache(CacheInterface $cache): static
    {
        $this->cache = $cache;
        return $this;
    }

    public function getCache(): CacheInterface
    {
        return $this->cache;
    }
}