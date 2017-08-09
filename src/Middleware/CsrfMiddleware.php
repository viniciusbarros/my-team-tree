<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MyTeamTree\Middleware;

/**
 * Description of CsrfMiddleware
 *
 * @author vinicius
 */
class CsrfMiddleware extends DefaultMiddleware
{

    public function __invoke($request, $response, $next)
    {
//        $this->csrf = $this->container->csrf;
//
//        $csrfFields = '<input type="hidden" name="%s" value="%s">'
//            .'<input type="hidden" name="%s" value="%s">';
//
//        $environment = $this->container->view->getEnvironment();
//        $environment->addGlobal('csrf',
//            [
//            'fields' => sprintf($csrfFields, $csrf->getTokenNameKey(),
//                $request->getAttribute($csrf->getTokenNameKey()), $csrf->getTokenValueKey(),
//                $request->getAttribute($csrf->getTokenValueKey()))
//            ]
//        );


        $response = $next($request, $response);
        return $response;
    }
}