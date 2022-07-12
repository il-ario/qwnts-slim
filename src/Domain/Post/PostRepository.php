<?php
declare(strict_types=1);

namespace App\Domain\Post;

use Doctrine\DBAL\Connection;

class PostRepository implements PostRepositoryInterface
{
    /**
     * @var Connection
     */
    protected Connection $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {   
        $this->connection = $connection;
    }

    /**
     * List posts
     * 
     * @param array $params
     */
    public function list(array $params)
    {
        $q = null;
        if (array_key_exists('q', $params)) {
            $q = $params['q'];
        }

        if (! is_null($q)) {
            $statement = "SELECT * FROM posts WHERE title LIKE '%$q%' OR body LIKE '%$q%'";
        } else {
            $statement = "SELECT * FROM posts";
        }
        
        $query = $this->connection->prepare($statement);
        $data = $query->executeQuery()->fetchAllAssociative();

        return $data;
    }

    /**
     * Store a new post
     * 
     * @param array $params
     */
    public function store(array $params)
    {
        $this->connection->insert('posts', [
            'title' => $params['title'],
            'body' => $params['body'],
            'status' => $params['status'],
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ]);

        return $this->connection->lastInsertId();
    }

    /**
     * Get a post via id
     * 
     * @param int $id
     */
    public function get(int $id)
    {
        $query = $this->connection->prepare("SELECT * FROM posts WHERE id = '$id'");
        $data = $query->executeQuery()->fetchAllAssociative();

        return $data;
    }

    /**
     * Update a post via id
     * 
     * @param int $id
     * @param array $params
     */
    public function update(int $id, array $params)
    {
        $data = $this->connection->update('posts', [
            'title' => $params['title'],
            'body' => $params['body'],
            'status' => $params['status'],
            'updatedAt' => date('Y-m-d H:i:s'),
        ], [
            'id' => $id
        ]);

        return $data;
    }
}
