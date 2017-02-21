<?php

/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 1/31/17
 * Time: 9:41 AM
 */
 namespace Middleware;
 use \Psr\Http\Message\ServerRequestInterface as Request;
 use \Psr\Http\Message\ResponseInterface as Response;
 use Utils\Utility;
class AuthMW extends  BaseMw
{

    public function __invoke(Request $request, Response $response, $next)
    {
        // TODO: Implement __invoke() method.
        if(!Utility::isLoggedIn()) {
            $this->container->user = Utility::setSession('user');
            return $response->withStatus(302)->withHeader('location','/login');
        }
        $response = $next($request, $response);
        return $response;
    }

}