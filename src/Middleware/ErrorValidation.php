<?php

namespace MyTeamTree\Middleware;

/**
 * Description of Middleware
 *
 * @author vinicius
 */
class ErrorValidation extends DefaultMiddleware
{

    public function __invoke($request, $response, $next)
    {
        if (isset($_SESSION['validationErrors'])) {
            $environment = $this->container->view->getEnvironment();
            $environment->addGlobal('errors', $_SESSION['validationErrors']);
            unset($_SESSION['validationErrors']);
        }

        $response = $next($request, $response);
        return $response;
    }
}