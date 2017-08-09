<?php
/**
 * Loads Persistant Input Middleware
 */
$container = $app->getContainer();

$app->add(new \MyTeamTree\Middleware\PersistantInput($container));