<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StoreUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(Request $request): Response
    {
        $parsedBody = $request->getParsedBody();

        $db = $this->container->get(PDO::class);
        $query = $db->prepare('INSERT INTO users (givenName, familyName, email, birthDate, password) VALUES (?, ?, ?, ?, ?)');
        $data = $query->execute([
            $parsedBody['givenName'],
            $parsedBody['familyName'],
            $parsedBody['email'],
            $parsedBody['birthDate'],
            sha1($parsedBody['password'])
        ]);
        
        return $this->respondWithData($data)->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
