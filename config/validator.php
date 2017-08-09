<?php
/**
 * Setup Validator as part of Container
 */
$container = $app->getContainer();

$container['validator'] = function($container) {
    return new MyTeamTree\Validation\Validator();
};

//Adding the Middleware
$app->add(new \MyTeamTree\Middleware\ErrorValidation($container));

