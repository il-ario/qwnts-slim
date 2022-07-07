<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ListUsersAction extends UserAction
{
    /**
     * List and sort users
     * 
     * {@inheritdoc}
     */
    protected function action(Request $request): Response
    {
        $parsedBody = $request->getQueryParams();

        $data = $this->userRepository->list($parsedBody);

        return $this->respondWithData($data)->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
