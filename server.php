<?php

use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;
use Swoose\Config;
use Swoose\Manager;
use Swotch\Watcher;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

require 'vendor/autoload.php';

$server = new Server("127.0.0.1", 9501);
$cache = new FilesystemAdapter('temp');
$sessionConfig = Config::create()->cache($cache);


$requestHandler = function (Request $request, Response $response) use ($sessionConfig) {
    $session = Manager::create($sessionConfig, $request, $response)->start();
    $session->put('name', 'Ahmard');

    $response->header("Content-Type", "text/plain");
    $response->end("Hello {$session->get('name')}\n");
};

$server->on("request", $requestHandler);
$server->on('start', function (Server $server){
    $paths = [
        __DIR__ . '/src'
    ];

    Watcher::watch($paths)->onAny(fn() => $server->reload());
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$server->start();