<?php
/**
 * Defining Constants
 */
define('DS', DIRECTORY_SEPARATOR);
define('CONFIG_PATH', dirname(__FILE__));

//Loading .env configs
require_once 'env.php';

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


// Instantiate the app
$app = new \Slim\App(MAIN_SLIM_SETTINGS);

//Loading View Configuration
require CONFIG_PATH.DS.'view.php';

//Loading Database
require CONFIG_PATH.DS.'database.php';

//Loading Validation
require CONFIG_PATH.DS.'validator.php';

//Loading Persinstant Input
require CONFIG_PATH.DS.'persistantInput.php';

//Loading Persinstant Input
//require CONFIG_PATH . DS . 'csrf.php';

$container['auth'] = function($container) {
    return new \MyTeamTree\Auth\Authentication();
};

$container['flash'] = function($container) {
    return new \Slim\Flash\Messages();
};

$container->get('view')->getEnvironment()->addGlobal('flash',
    $container->get('flash'));
