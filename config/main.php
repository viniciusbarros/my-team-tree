<?php
/**
 * Defining Constants
 */
define('DS', DIRECTORY_SEPARATOR);
define('CONFIG_PATH', dirname(__FILE__));
define('PROJECT_PATH', dirname(CONFIG_PATH));
define('SOURCE_PATH', PROJECT_PATH . DS . 'src');
define('TEMPLATES_PATH', PROJECT_PATH . DS . 'templates');
define('PUBLIC_PATH', PROJECT_PATH . DS . 'public');
define('MAIN_SLIM_SETTINGS', [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],
        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
]);

//Loading .env configs
require_once 'env.php';

/**
 * IMPORTANT: We don't load the view.php here as it needs the container. So it is loaded in the index.php
 */
