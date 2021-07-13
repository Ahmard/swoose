<?php


namespace Swoose;


use JetBrains\PhpStorm\Pure;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class Config
{
    protected AdapterInterface $adapter;
    protected string $secretKey = 'secret';
    protected string $cookieName = 'SWOOLE_SESSION_ID';


    #[Pure] public static function create(): static
    {
        return new static();
    }

    /**
     * @param AdapterInterface $adapter
     * @return $this
     */
    public function setAdapter(AdapterInterface $adapter): static
    {
        $this->adapter = $adapter;
        return $this;
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter(): AdapterInterface
    {
        return $this->adapter;
    }

    /**
     * @param string $secretKey
     */
    public function setSecretKey(string $secretKey): void
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * @param string $cookieName
     */
    public function setCookieName(string $cookieName): void
    {
        $this->cookieName = $cookieName;
    }

    /**
     * @return string
     */
    public function getCookieName(): string
    {
        return $this->cookieName;
    }
}