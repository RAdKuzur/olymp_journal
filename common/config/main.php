<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '172.16.0.94',
            'port' => 6379,
            'database' => 0,
        ],
        'rabbitmq' => [
            'class' => 'common\components\RabbitMQComponent',
            'host' => '172.16.0.94',
            'port' => 5672,
            'user' => 'test',
            'password' => 'test',
            'vhost' => '/',
        ],
        'apiService' => [
            'class' => 'common\services\ApiService',
            'baseUrl' => 'http://172.16.0.94/olymp_journal/frontend/web/api',
            'timeout' => 60,
            'defaultHeaders' => [
                'Authorization' => 'Bearer your-access-token',
            ],
        ],
        'categories' => [
            'class' => 'common\components\dictionaries\CategoryDictionary',
        ],
        'disability' => [
            'class' => 'common\components\dictionaries\DisabilityDictionary',
        ],
        'genders' => [
            'class' => 'common\components\dictionaries\GenderDictionary',
        ],
        'regions' => [
            'class' => 'common\components\dictionaries\RegionDictionary',
        ],
        'countries' => [
            'class' => 'common\components\dictionaries\CountryDictionary',
        ],
        'classes' => [
            'class' => 'common\components\dictionaries\ClassDictionary',
        ]

    ],
];
