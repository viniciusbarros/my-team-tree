<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MyTeamTree\Middleware;

/**
 * Description of Middleware
 *
 * @author vinicius
 */
class DefaultMiddleware
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }
}