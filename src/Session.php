<?php


namespace Swoose;


use Swoole\Http\Request;
use Swoole\Http\Response;

class Session
{
    public function __construct(
        protected Config $config,
        protected Request $request,
        protected Response $response,
    )
    {
    }

    public function put(string $key, mixed $data): void
    {

    }

    public function get(string $key): mixed
    {

    }
}