<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DeleteUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(Request $request): Response
    {
        $email = $this->resolveArg('email');

        $data = $this->userRepository->delete($email);

        return $this->respondWithData($data)->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
