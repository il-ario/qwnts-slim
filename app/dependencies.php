<?php
declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Tuupola\Middleware\JwtAuthentication;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        Connection::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $dbSettings = $settings->get('db');

            $config = new Configuration();
            $connectionParams = [
                'dbname' => $dbSettings['dbname'],
                'user' => $dbSettings['user'],
                'password' => $dbSettings['password'],
                'host' => $dbSettings['host'],
                'charset' => 'utf8mb4',
                'driver' => 'pdo_mysql',
                'unix_socket' => null,
                // 'port' => 3306,
            ];

            try {
                return DriverManager::getConnection($connectionParams, $config);
            } catch (\Exception $e) {
                echo $e->getMessage();
                die();
            }
        },
        JwtAuthentication::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $jwtSettings = $settings->get('jwt');

            $jwt = new Tuupola\Middleware\JwtAuthentication([
                "secret" => $jwtSettings['secret'],
                "rules" => [
                    new Tuupola\Middleware\JwtAuthentication\RequestPathRule([
                        "path" => "/",
                        "ignore" => ["/login"]
                    ]),
                    new Tuupola\Middleware\JwtAuthentication\RequestMethodRule([
                        "ignore" => ["OPTIONS"]
                    ])
                ]
            ]);
            
            return $jwt;
        }
    ]);
};
