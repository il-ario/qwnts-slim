<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use PDO;
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

        $statement = 'SELECT * FROM users';

        /**
         * If sort options are present, compose the query statement
         */
        if (array_key_exists('sort', $parsedBody)) {
            $length = count($parsedBody['sort']);
            $statement .= ' ORDER BY ';
            
            foreach ($parsedBody['sort'] as $key => $value) {
                $statement .= substr($value, 1);

                if (substr($value, 0, 1) === '-') {
                    $statement .= ' DESC ';
                } else {
                    $statement .= ' ASC ';
                }

                if (! $key == $length) {
                    $statement .= ', ';
                }
            }
        }

        $db = $this->container->get(PDO::class);
        $query = $db->query($statement);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        return $this->respondWithData($data)->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
