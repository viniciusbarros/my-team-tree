<?php
/**
 * Defining Constants
 */
define('DS', DIRECTORY_SEPARATOR);
define('CONFIG_PATH', dirname(__FILE__));

/**
 * .ENV Configurations
 */
$envRequiredConstants = [
    'DB_HOST',
    'DB_NAME',
    'DB_USER',
    'DB_PASS'
];

$dotenv = new Dotenv\Dotenv(CONFIG_PATH);
$dotenv->load();
$dotenv->required($envRequiredConstants);

/**
 * Continuing Defining Constants
 */
define('PROJECT_PATH', dirname(CONFIG_PATH));
define('SOURCE_PATH', PROJECT_PATH.DS.'src');
define('TEMPLATES_PATH', PROJECT_PATH.DS.'templates');
define('PUBLIC_PATH', PROJECT_PATH.DS.'public');
define('SITE_TITLE', env('SITE_TITLE', 'My Team Tree'));
define('MAIN_SLIM_SETTINGS',
    [
    'settings' => [
        'displayErrorDetails' => env('DEBUG'), // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__.'/../templates/',
        ],
        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__.'/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'db' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST'),
            'database' => env('DB_NAME'),
            'username' => env('DB_USER'),
            'password' => env('DB_PASS'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
        ]
    ],
]);


/**
 *  Instantiating the app
 */
$app = new \Slim\App(MAIN_SLIM_SETTINGS);

/**
 * Getting the app Container
 */
$container = $app->getContainer();

/**
 * View Configuration
 * 
 * Using Twig as view renderer
 * and attaching it to the container
 */
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

/**
 * Database Configuration
 *
 * Using Eloquent as DB Manager
 */
$capsule         = new \Illuminate\Database\Capsule\Manager();
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();
//Adding to Container
$container['db'] = function($container) use ($capsule) {
    return $capsule;
};

/**
 * Validation Configuration
 */
//Attaching to container
$container['validator'] = function($container) {
    return new MyTeamTree\Validation\Validator();
};

//Middleware
$app->add(new \MyTeamTree\Middleware\ErrorValidation($container));

/**
 * Persistent Input Configuration
 */
//Middleware
$app->add(new \MyTeamTree\Middleware\PersistantInput($container));

/**
 * CSRF Configuration
 */
//// Adding to Container
//$container['csrf'] = function($container){
//    $guard = new Slim\Csrf\Guard();
//    return $guard;
//};
////Adding to app
//$app->add($container->csrf);
//
////Adding middleware
//$app->add(new \MyTeamTree\Middleware\CsrfMiddleware($container));

/**
 * Authentication Configuration
 */
//Middleware
$container['auth'] = function($container) {
    return new \MyTeamTree\Auth\Authentication();
};

//Adding to View
$container->get('view')->getEnvironment()->addGlobal(
    'auth', $container->get('auth')
);

/**
 * Flash Messages Configuration
 */
//Middleware
$container['flash'] = function($container) {
    return new \Slim\Flash\Messages();
};

//Adding Flash object to View
$container->get('view')->getEnvironment()->addGlobal(
    'flash', $container->get('flash')
);
