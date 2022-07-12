<?php
declare(strict_types=1);

namespace App\Application\Actions\Post;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdatePostAction extends PostAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(Request $request): Response
    {
        $parsedBody = $request->getParsedBody();
        $id = $this->resolveArg('id');

        $data = $this->postRepository->get((int) $id);

        if (empty($data)) {
            return $this->respondWithData(['error' => 'Incorrect data.'])->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        $this->postRepository->update((int) $id, $parsedBody);
        $data = $this->postRepository->get((int) $id);

        return $this->respondWithData($data)->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
