<?php

/**
 * Phundament 3 Console Config File
 * Containes predefined yiic console commands for Phundament.
 * Define composer hooks by the following name schema: <vendor>/<packageName>-<action>

 */

// for testing purposes
$webappCommand = array(
    'yiic',
    'webapp',
    'create',
    realpath(dirname(__FILE__) . '/../../'),
    'git',
    '--interactive=' . (getenv('PHUNDAMENT_TEST') ? '0' : '1')
);

// gets merged automatically if available
$localConsoleConfigFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'console-local.php';

// merge compnents and modules from main config
$mainConfig = require('main.php');

$consoleConfig = array(
    'aliases'    => array(
        'vendor'  => dirname(__FILE__) . '/../../vendor',
        'webroot' => dirname(__FILE__) . '/../../www',
        'gii-template-collection' => 'vendor.phundament.gii-template-collection', // TODO
    ),
    'basePath'   => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'       => 'Phundament Console Application',
    'components' => CMap::mergeArray(
        $mainConfig['components'],
        array()
    ),
    'modules'    => $mainConfig['modules'],
    'commandMap' => array(
        // composer callback
        'webapp'        => array(
            'class' => 'application.commands.P3WebAppCommand',
        ),
    ),
    'params'     => array(
        'composer.callbacks' => array(
            // command and args for Yii command runner
            'yiisoft/yii-install'              => $webappCommand,
            'post-install'                     => array(
                'yiic',
                'p3echo',
                "Yii Post-Install"
            ),
            'post-update'                      => array(
                'yiic',
                'p3echo',
                "Yii Post-Update"
            ),
        ),
    )
);

// return merged config, from highest to lowest precedence: console-local, console
if (is_file($localConsoleConfigFile)) {
    return CMap::mergeArray($consoleConfig, require($localConsoleConfigFile));
} else {
    return $consoleConfig;
}