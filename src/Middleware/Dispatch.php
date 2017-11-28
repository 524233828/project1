<?php
namespace Middleware;

use Constant\ErrorCode;
use Exception\BaseException;
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
        ini_set('session.gc_maxlifetime',   config()->get("session_expire"));
        ini_set('session.cookie_lifetime',  config()->get("session_expire"));
        try {
            $response = $next($request);
        } catch (\Exception $e) {

            if($e->getCode()!==0){
                $response = new ApiResponse(
                    $e->getMessage(),
                    $e->getCode(),
                    null,
                    ErrorCode::status($e->getCode())
                );
            }else{
                BaseException::SystemError();
            }
        }

        return $response;
    }
}