<?php
/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 1/31/17
 * Time: 10:12 AM
 */

namespace Middleware;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Utils\Utility;


class LayoutMw extends BaseMw
{

    public function __invoke(Request $request, Response $response, $next)
    {
        // TODO: Implement __invoke() method.
        if(!Utility::isLoggedIn()) {
           $this->container->renderer->render($response, 'no_auth_header.phtml', []);
        }

        $response = $next($request, $response);

        if(!Utility::isLoggedIn()) {
            $this->container->renderer->render($response, 'no_auth_footer.phtml', []);
        }

        return $response;
    }
}