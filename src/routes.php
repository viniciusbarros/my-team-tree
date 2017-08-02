<?php
// Routes

$app->get('/[{name}]', function($request, $response, $args){
    
    $args['extras'] = [
        'Twig Templating',
        '.env Environment configuration',
        'Autoload for SRC Folder'
    ];
    
    $this->logger->info("Example route");
    
   return $this->view->render($response, 'index.twig', $args);
});

//$app->get('/[{name}]', function ($request, $response, $args) {
//    // Sample log message
//    $this->logger->info("Slim-Skeleton '/' route");
//
//    // Render index view
//    return $this->renderer->render($response, 'index.phtml', $args);
//});