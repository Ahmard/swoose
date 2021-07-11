<?php


namespace Swoose;


use JetBrains\PhpStorm\Pure;
use Swoole\Http\Request;
use Swoole\Http\Response;

class Manager
{
    #[Pure] public static function create(
        Config $config,
        Request $request,
        Response $response
    ): static
    {
        return new static($config, $request, $response);
    }


    public function __construct(
        protected Config $config,
        protected Request $request,
        protected Response $response
    )
    {
    }

    #[Pure] public function start(): Session
    {
        return new Session($this->config, $this->request, $this->response);
    }
}