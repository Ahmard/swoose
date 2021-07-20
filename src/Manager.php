<?php


namespace Swoose;


use Exception;
use JetBrains\PhpStorm\Pure;
use Psr\Cache\InvalidArgumentException;
use Swoole\Http\Request;
use Swoole\Http\Response;

class Manager
{
    /**
     * @throws Exception
     */
    #[Pure] public static function create(
        Config $config,
        Request $request,
        Response $response
    ): static
    {
        return new static($config, $request, $response);
    }


    /**
     * @throws Exception
     */
    public function __construct(
        protected Config $config,
        protected Request $request,
        protected Response $response
    )
    {
        #$handler = (new Handler($this->request, $this->response));
        #$encKey = $handler->getKey($this->config->getCookieName());
    }

    /**
     * @throws InvalidArgumentException
     */
    public function start(): Session
    {
        $sessId = $this->request->cookie[$this->config->getCookieName()] ?? null;

        if (!$sessId) {
            $sessId = md5(uniqid());

            $this->response->cookie(
                name: $this->config->getCookieName(),
                value: $sessId
            );
        }

        return new Session($this->config->getAdapter(), $sessId);
    }
}