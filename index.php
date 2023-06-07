<?php

use Flawless\Http\FlawlessHttp;

$root = __DIR__;
require_once "$root/vendor/autoload.php";

$flawless = FlawlessHttp::boot();
$flawless->registerConfigFrom("$root/config/container.php");
$flawless->registerEndpointsFrom("$root/config/endpoints.php");
$flawless->app()->execute();
