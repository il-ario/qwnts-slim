<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use PDO;
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

        $db = $this->container->get(PDO::class);
        $query = $db->prepare("DELETE FROM users WHERE email = '$email'");
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        return $this->respondWithData($data)->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
