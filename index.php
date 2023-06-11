<?php

use App\Middleware\RequestStdoutMiddleware;
use App\Snakee\Middleware\RequestContextMiddleware;
use Flawless\Http\FlawlessHttp;

$root = __DIR__;
require_once "$root/vendor/autoload.php";

$flawless = FlawlessHttp::boot();

$flawless->registerConfigFrom("$root/config/config.php");
$flawless->registerEndpointsFrom("$root/config/endpoints.php");
$flawless->enableGlobalMiddleware(RequestStdoutMiddleware::class);

$snakee = $flawless->snakee([RequestContextMiddleware::class]);

$flawless->execute();
