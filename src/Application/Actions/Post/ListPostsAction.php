<?php
declare(strict_types=1);

namespace App\Application\Actions\Post;

use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ListPostsAction extends PostAction
{
    /**
     * List posts with search
     * 
     * {@inheritdoc}
     */
    protected function action(Request $request): Response
    {
        $q = null;
        $parsedBody = $request->getQueryParams();
        
        if (array_key_exists('q', $parsedBody)) {
            $q = $parsedBody['q'];
        }

        $db = $this->container->get(PDO::class);

        if (! is_null($q)) {
            $query = $db->query("SELECT * FROM posts WHERE title LIKE '%$q%' OR body LIKE '%$q%'");
        } else {
            $query = $db->query('SELECT * FROM posts');
        }
        
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        return $this->respondWithData($data)->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
