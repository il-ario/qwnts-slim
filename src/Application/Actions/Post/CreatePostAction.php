<?php
declare(strict_types=1);

namespace App\Application\Actions\Post;

use App\Domain\Post\Post;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CreatePostAction extends PostAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(Request $request): Response
    {
        $parsedBody = $request->getParsedBody();

        $post = new Post(
            title: $parsedBody['title'],
            body: $parsedBody['body'],
            status: $parsedBody['status']
        );

        $lastInsertId = $this->postRepository->store($parsedBody);
        $data = $this->postRepository->get((int) $lastInsertId);
        
        return $this->respondWithData($data)->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
