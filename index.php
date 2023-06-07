<?php

use App\Endpoint\HelloEndpointHandler;
use Flawless\Http\FlawlessHttp;

$root = __DIR__;
require_once "$root/vendor/autoload.php";

$flawless = FlawlessHttp::boot();
$flawless->registerConfigFrom("$root/config/container.php");
$flawless->app()->registerEndpoint('GET', '/hello', HelloEndpointHandler::class);
$flawless->app()->execute();
