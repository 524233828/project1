<?php
namespace Middleware;

use Constant\ErrorCode;
use FastD\Middleware\DelegateInterface;
use FastD\Middleware\Middleware;
use Psr\Http\Message\ServerRequestInterface;
use Service\ApiResponse;

class Dispatch extends Middleware
{

    public function handle(ServerRequestInterface $request, DelegateInterface $next)
    {
        //开启session会话
        session_start();

        try {
            $response = $next($request);
        } catch (\Exception $e) {
            $response = new ApiResponse(
                $e->getMessage(),
                $e->getCode(),
                null,
                ErrorCode::status($e->getCode())
            );
        }

        return $response;
    }
}