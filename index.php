<?php

use App\Middleware\Test\RequestStdoutMiddleware;
use App\Snakee\Middleware\RequestContextMiddleware;
use Flawless\Http\FlawlessHttp;
use Flawless\Kernel\Plugin\Base\DoctrinePlugin;

$root = __DIR__;
require_once "$root/vendor/autoload.php";

$flawless = FlawlessHttp::boot();

$flawless->registerConfigFrom("$root/config/config.php");
$flawless->registerEndpointsFrom("$root/config/endpoints.php");
$flawless->enableGlobalMiddleware(RequestStdoutMiddleware::class);

$flawless->enablePlugin(DoctrinePlugin::class);

$snakee = $flawless->snakee([RequestContextMiddleware::class]);

$flawless->execute();
