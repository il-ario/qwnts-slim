<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use PDO;
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
        
        $db = $this->container->get(PDO::class);
        $query = $db->prepare("UPDATE users SET givenName = ?, familyName = ?, email = ?, birthDate = ?, password = ? WHERE email = '$email'");
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
