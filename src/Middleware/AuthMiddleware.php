<?php

namespace MyTeamTree\Middleware;

/**
 * Guarantees user only have access to certain routes when logged in
 */
class AuthMiddleware extends DefaultMiddleware
{

    public function __invoke($request, $response, $next)
    {
        $container = $this->container;

        if (!$this->container->auth->isAuthenticated()) {
            $this->container->flash->addMessage('error',
                "You must be authenticated to see this page, please do login.");
            return $response->withRedirect($this->container->router->pathFor('login'));
        }

        $response = $next($request, $response);
        return $response;
    }
}