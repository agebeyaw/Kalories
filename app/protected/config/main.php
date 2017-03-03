<?php

// Set the path of Bootstrap to be the root of the project.
Yii::setPathOfAlias('bootstrap', realpath(__DIR__ . '/../../../'));

$config = array(
    'basePath' => realpath(__DIR__ . '/..'),
    'name' => 'Kalories',
    'timeZone' => 'Europe/Rome',
    'defaultController' => 'meals',
    'preload' => array(
        'bootstrap',
        'log',
    ),
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.modules.UserAdmin.components.*',
        'application.modules.UserAdmin.models.*',
        'ext.ECompositeUniqueValidator',
    ),
    'modules' => array(
        'UserAdmin',
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'Kalories',
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array('bootstrap.gii'),
        ),
    ),
    'components' => array(
        'bootstrap' => array(
            'class' => 'bootstrap.components.Bootstrap',
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
        'urlManager' => array(
            'showScriptName' => false,
            'urlFormat' => 'path',
            'urlSuffix' => '.html',
            'rules' => array(
                'index' => 'meals/admin',
                'setup' => 'site/setup',
                '<_c:\w+>' => '<_c>',
                '<_c:\w+>/<_a:\w+>' => '<_c>/<_a>',
                '<_m:\w+>' => '<_m>',
                '<_m:\w+>/<_c:\w+>' => '<_m>/<_c>',
                '<_m:\w+>/<_c:\w+>/<_a:\w+>' => '<_m>/<_c>/<_a>',
            ),
        ),
        'user' => array(
            'class' => 'UWebUser',
            'allowAutoLogin' => true,
            'loginUrl' => array('/UserAdmin/auth/login'),
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=kalories_motork',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ),
    ),
    // Application-level parameters
    'params' => array(
        'appTitle' => 'Kalories - Bringing together the Yii PHP framework and Twitter\'s Bootstrap',
        'appDescription' => 'Kalories is an Calories Management Application that provides a wide range of server-side widgets that allow you to easily use Bootstrap with Yii.',
    ),
);

return file_exists(dirname(__FILE__) . '/local.php') ? CMap::mergeArray($config, require('local.php')) : $config;
