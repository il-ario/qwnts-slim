<?php
declare(strict_types=1);

namespace App\Application\Actions\Post;

use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ViewPostAction extends PostAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(Request $request): Response
    {
        $id = $this->resolveArg('id');

        $data = $this->postRepository->view((int) $id);
        
        return $this->respondWithData($data)->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
