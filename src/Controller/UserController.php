<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MyTeamTree\Controller;

use Respect\Validation\Validator as RespValidator;
use MyTeamTree\Model\User;
use MyTeamTree\Middleware\AuthMiddleware;

/**
 * Description of UserController
 *
 * @author vinicius
 */
class UserController extends DefaultController
{

    public static function setRoutes(&$app)
    {
        $app->get('/login', self::class.':login')->setName('login');
        $app->post('/login', self::class.':postLogin');
        $app->get('/logout', self::class.':logout')->setName('logout');

        //Authenticated routes
        $app->group('',
            function() {
            $this->get('/user/test-page', self::class.':testPage');
        })->add(new AuthMiddleware($app->getContainer()));
    }

    /**
     * Renders the login page
     *
     * @param type $request
     * @param type $response
     * @param array $args
     */
    public function login($request, $response, $args)
    {
        if ($this->auth->isAuthenticated()) {
            return $response->withRedirect($this->router->pathFor('authenticatedHome'));
        }
        
        $args['title'] = SITE_TITLE.' - Login';
        $this->render($response, 'user/login.twig', $args);
    }

    /**
     * Does the user login
     *
     * @param type $request
     * @param type $response
     * @param type $args
     */
    public function postLogin($request, $response, $args)
    {
        $validation = $this->validator->validate($request,
            [
            'email' => RespValidator::noWhitespace()->notEmpty()->email(),
            'password' => RespValidator::noWhitespace()->notEmpty()->length(8,
                null),
        ]);


        if ($validation->failed()) {
            $redirect = 'login';
        } else {
            //$this->auth->logout();
            $authentication = $this->auth->doAuthentication($request->getParam('email'),
                $request->getParam('password'));


            if (!$authentication->isAuthenticated()) {
                $redirect = 'login';
            } else {
                $redirect = 'login';
            }
        }

        if (!$this->auth->isAuthenticated()) {
            $this->flash->addMessage('error',
                'Authentication Failed. Please check your login details');
        }

        return $response->withRedirect($this->router->pathFor($redirect));
    }

    public function logout($request, $response, $args)
    {
        $this->auth->logout();

//        echo '<pre style="background-color:#e5eefc; margin: 5px; padding:5px; border:dashed 1px blue; margin-top:0px;"><strong style="color:blue">'.__FILE__.' line '.__LINE__.'</strong><br>';
//        var_dump($_SESSION);
//        die('</pre>');

        return $response->withRedirect($this->router->pathFor('login'));
    }
}