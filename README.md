# Swoose 
A [Swoole](https://swoole.co.uk) http session library.

### This library is experimental

## Installation
```
composer require ahmard/swoose
```

## Usage
```php
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;
use Swoose\Config;
use Swoose\Manager;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

require 'vendor/autoload.php';

$server = new Server("127.0.0.1", 9501);

$cache = new FilesystemAdapter(directory: __DIR__ . '/.temp');
$sessionConfig = Config::create()
    ->setAdapter($cache);


$requestHandler = function (Request $request, Response $response) use ($sessionConfig) {
    $session = Manager::create($sessionConfig, $request, $response)->start();

    $session->put('visit', ($session->get('visit') ?? 0) + 1 );
    
    if (!$session->has('name')) {
        $session->put('name', 'Ahmard');
        var_dump('Guest');
    } else {
        var_dump('User');
    }

    $response->header("Content-Type", "text/plain");
    $response->end("Hello {$session->get('name')} @ {$session->get('visit')}\n");
};

$server->on("request", $requestHandler);
$server->on('start', function () {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$server->start();
```