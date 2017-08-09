<?php
/**
 * Loads Persistant Input Middleware
 */
$container = $app->getContainer();

/**
 * CSRF
 */
$container['csrf'] = function($container){
    $guard = new Slim\Csrf\Guard();
    return $guard;
};
$app->add($container->csrf);

//Adding middleware

$app->add(new \MyTeamTree\Middleware\CsrfMiddleware($container));