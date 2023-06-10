<?php

use App\Middleware\RequestStdoutMiddleware;
use Flawless\Container\Container;
use Flawless\Http\FlawlessHttp;
use Psr\Container\ContainerInterface;

$root = __DIR__;
require_once "$root/vendor/autoload.php";

$flawless = FlawlessHttp::boot();

$flawless->registerConfigFrom("$root/config/config.php");
$flawless->registerEndpointsFrom("$root/config/endpoints.php");
$flawless->enableGlobalMiddleware(RequestStdoutMiddleware::class);
$flawless->bind(ContainerInterface::class, Container::class);

$flawless->execute();
