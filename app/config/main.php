<?php

/**
 * Phundament 3 Application Config File
 * All modules and components have to be declared before installing a new package via composer.
 * See also config.php, for composer installation and update "hooks"
 */

// configuration files precedence: main-local, main-{env}, main

// also includes environment config file, eg. 'development' or 'production', we merge the files (if available!) at the botton
$localConfigFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'main-local.php';

// convenience variables
$applicationDirectory = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
$baseUrl              = (dirname($_SERVER['SCRIPT_NAME']) == '/' || dirname($_SERVER['SCRIPT_NAME']) == '\\') ? '' :
    dirname($_SERVER['SCRIPT_NAME']);

// main application configuration
$mainConfig = array(
    'basePath'   => $applicationDirectory,
    'name'       => 'Vanilla Inc.',
    'theme'      => 'frontend', // theme is copied eg. from vendor/p3bootstrap
    'language'   => 'en',
    'preload'    => array(
        'log',
    ),
    'aliases'    => array(
        'vendor' => $applicationDirectory.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'
    ),
    // autoloading model and component classes
    'import'     => array(
        'application.models.*',
        'application.components.*',
    ),
    'components' => array(
        'db'   => array(
            // MySQL
            'class'            => 'CDbConnection',
            'tablePrefix'      => '',
            'connectionString' => 'sqlite:' . $applicationDirectory . '/data/default.db',
        ),
    ),
    'modules'    => array(

    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'     => array(

    ),
);


if (is_file($localConfigFile)) {
    return CMap::mergeArray($mainConfig, require($localConfigFile));
} else {
    return $mainConfig;
}
