<?php
declare(strict_types=1);

namespace App\Application\Actions\Post;

use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StorePostAction extends PostAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(Request $request): Response
    {
        $parsedBody = $request->getParsedBody();

        $db = $this->container->get(PDO::class);
        $query = $db->prepare('INSERT INTO posts (title, body, status) VALUES (?, ?, ?)');
        $data = $query->execute([
            $parsedBody['title'],
            $parsedBody['body'],
            $parsedBody['status']
        ]);
        
        return $this->respondWithData($data)->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}