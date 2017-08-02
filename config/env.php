<?php

/**
 * Required Constants in .env file
 */
$envRequiredConstants = [
    'DB_HOST',
    'DB_NAME',
    'DB_USER',
    'DB_PASS'
];

//Loading .env
$dotenv = new Dotenv\Dotenv(CONFIG_PATH);
$dotenv->load();
$dotenv->required($envRequiredConstants);

/**
 * Smaller alias function to get .env variables
 * @param type $parameter
 * @return type
 */
function env($parameter, $default = false) {
    $value = getenv($parameter);
    //If not found, uses the default value
    if ($value == false) {
        $finalValue = $default;
    } else {
        switch (strtolower($value)) {
            case 'true':
                $finalValue = true;
                break;
            case 'false':
                $finalValue = false;
                break;
            case 'null':
                $finalValue = null;
                break;
            default :
                $finalValue = $value;
                break;
        }
    }

    return $finalValue;
}
