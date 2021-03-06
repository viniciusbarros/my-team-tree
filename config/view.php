<?php
/**
 * Setup Twig as main view
 */
$container = $app->getContainer();

$container['view'] = function($container) {
    $view = new Slim\Views\Twig(TEMPLATES_PATH,
        [
        'cache' => env('TWIG_CACHE', false),
        'debug' => true,
        ]
    );
    $view->addExtension(new Slim\Views\TwigExtension($container->router,
        $container->request->getUri()));
    $view->addExtension(new Twig_Extension_Debug());
    return $view;
};
