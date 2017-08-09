<?php

// Routes

use MyTeamTree\Middleware\authMiddleware;
use MyTeamTree\Controller\AppController;
use MyTeamTree\Controller\UserController;

//$app->get('/', \MyTeamTree\Controller\App::class . ':home' )->setName('home');

AppController::setRoutes($app);
UserController::setRoutes($app);
