<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'webnurse',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log',],
    'language' => 'pt-br',
    'timezone' => 'America/Sao_Paulo',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '6mYWtFFZVZa9lPhz4b6KXeOfBIWxf2Sm',
        ],
        'formatter' => [
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-m-Y H:i:s',
            'timeFormat' => 'php:H:i:s',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => 'R$',
            'defaultTimeZone' => 'America/Sao_Paulo',
            'locale' => 'pt-br',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'session' => [
            'timeout' => 3600,
		        'class' => 'yii\web\DbSession',
		        'sessionTable' => 'yiisession',
        ],
        'user' => [
            'identityClass' => 'app\models\Usuario',
            'enableAutoLogin' => true,
            'enableSession' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        'db' => require(__DIR__ . '/db.php'),
        'HCPA' => require(__DIR__ . '/hcpa.php'),
        'HDP' => require(__DIR__ . '/hdp.php'),
        'ICFUC' => require(__DIR__ . '/icfuc.php'),
        'HMD' => require(__DIR__ . '/hmd.php'),

        'urlManager' => [
            'enablePrettyUrl' => false,
            'showScriptName' => true,
            'rules' => [
            ],
        ],

    ],
    'params' => $params,

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
