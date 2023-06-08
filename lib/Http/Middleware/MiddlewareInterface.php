<?php

namespace Flawless\Http\Middleware;

use Flawless\Http\Request\Request;

interface MiddlewareInterface
{
    public function handle(Request $request): Request;
}
