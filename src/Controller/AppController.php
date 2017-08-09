<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MyTeamTree\Controller;

use MyTeamTree\Middleware\AuthMiddleware;

/**
 * Description of AppController
 *
 * @author vinicius
 */
class AppController extends DefaultController
{

    public static function setRoutes(&$app)
    {
        $app->get('/', self::class.':home')->setName('home');

        //Authenticated routes
        $app->group('',
            function() {
            $this->get('/home', self::class.':authenticatedHomePage')->setName('authenticatedHome');
        })->add(new AuthMiddleware($app->getContainer()));
    }

    public function home($request, $response, $args)
    {
        $this->renderPage($response, 'app/home.twig', $args);
    }

    public function authenticatedHomePage($request, $response, $args)
    {
        $args['title'] = SITE_TITLE.' - Home';
        $this->render($response, 'app/authenticated-home.twig', $args);
    }
}