<?php

use App\Middleware\RandomErrorMiddleware;
use Flawless\Http\FlawlessHttp;

$root = __DIR__;
require_once "$root/vendor/autoload.php";

$flawless = FlawlessHttp::boot();

$flawless->registerConfigFrom("$root/config/config.php");
$flawless->registerEndpointsFrom("$root/config/endpoints.php");
$flawless->enableGlobalMiddleware(RandomErrorMiddleware::class);

$flawless->execute();
