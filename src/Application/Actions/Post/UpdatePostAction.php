<?php
declare(strict_types=1);

namespace App\Application\Actions\Post;

use PDO;
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
        
        $db = $this->container->get(PDO::class);
        $query = $db->prepare("UPDATE posts SET title = ?, body = ?, status = ? WHERE id = $id");
        $data = $query->execute([
            $parsedBody['title'],
            $parsedBody['body'],
            $parsedBody['status']
        ]);

        return $this->respondWithData($data)->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
