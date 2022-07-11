<?php
declare(strict_types=1);

namespace App\Application\Actions\Post;

use App\Application\Actions\Action;
use App\Domain\Post\PostRepository;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

abstract class PostAction extends Action
{
    protected PostRepository $postRepository;
    protected string $tableName;

    public function __construct(LoggerInterface $logger, ContainerInterface $container, PostRepository $postRepository)
    {
        parent::__construct($logger, $container);
        $this->postRepository = $postRepository;
        $this->tableName = 'posts';
    }
}


