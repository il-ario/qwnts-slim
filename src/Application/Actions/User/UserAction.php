<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

abstract class UserAction extends Action
{
    public function __construct(LoggerInterface $logger, ContainerInterface $container)
    {
        parent::__construct($logger, $container);
    }
}

