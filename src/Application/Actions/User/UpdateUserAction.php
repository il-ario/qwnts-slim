<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(Request $request): Response
    {
        $email = $this->resolveArg('email');
        $parsedBody = $request->getParsedBody();

        $data = $this->userRepository->getEmail($email);

        if (empty($data)) {
            return $this->respondWithData(['error' => 'Incorrect data.'])->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        $this->userRepository->update($email, $parsedBody);
        $data = $this->userRepository->getEmail($email);

        return $this->respondWithData($data)->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
