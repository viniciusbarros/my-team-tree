<?php

namespace MyTeamTree\Middleware;

/**
 * This middleware is responsible for keeping inputs persistant after 
 * a form submission by making them globally available in the view
 *
 * @author vinicius
 */
class PersistantInput extends DefaultMiddleware
{

    public function __invoke($request, $response, $next)
    {
        if (isset($_SESSION['input'])) {
            $environment = $this->container->view->getEnvironment();
            $environment->addGlobal('input', $_SESSION['input']);
        }
        $_SESSION['input'] = $request->getParams();

        $response = $next($request, $response);
        return $response;
    }
}