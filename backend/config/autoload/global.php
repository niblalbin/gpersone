<?php
return [
    'api-tools-content-negotiation' => [
        'selectors' => [],
    ],
    'db' => [
        'driver' => \Pdo::class,
        'dsn' => 'mysql:dbname=gpersone;host=localhost;charset=utf8',
        'username' => 'root',
        'password' => '',
        'driver_options' => [
            3 => 2,
        ],
        'adapters' => [
            'gpersone' => [],
        ],
    ],
    'service_manager' => [
        'factories' => [
            Laminas\Db\Adapter\AdapterInterface::class => Laminas\Db\Adapter\AdapterServiceFactory::class,
        ],
    ],
];
