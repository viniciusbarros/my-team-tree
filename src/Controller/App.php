<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MyTeamTree\Controller;

/**
 * Description of App
 *
 * @author vinicius
 */
class App extends DefaultController
{

    public function home($request, $response, $args)
    {
        $this->renderPage($response, 'app/home.twig', $args);
    }
}