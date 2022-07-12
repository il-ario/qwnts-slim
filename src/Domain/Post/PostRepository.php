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
        $data = $query->executeQuery();

        return $data;
    }

    /**
     * Store a new post
     * 
     * @param array $params
     */
    public function store(array $params)
    {
        $statement = "INSERT INTO posts (title, body, status, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?)";
        
        $query = $this->connection->prepare($statement);
        $query->bindValue(1, $params['title']);
        $query->bindValue(2, $params['body']);
        $query->bindValue(3, $params['status']);
        $query->bindValue(4, date('Y-m-d H:i:s'));
        $query->bindValue(5, date('Y-m-d H:i:s'));
        $data = $query->executeQuery();

        return $data;
    }

    /**
     * Get a post via id
     * 
     * @param int $id
     */
    public function get(int $id)
    {
        $query = $this->connection->prepare("SELECT * FROM posts WHERE id = '$id'");
        $data = $query->executeQuery();

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
        $statement = "UPDATE posts SET title = ?, body = ?, status = ?, updatedAt = ? WHERE id = $id";
        
        $query = $this->connection->prepare($statement);
        $query->bindValue(1, $params['title']);
        $query->bindValue(2, $params['body']);
        $query->bindValue(3, $params['status']);
        $query->bindValue(4, date('Y-m-d H:i:s'));
        $data = $query->executeQuery();

        return $data;
    }
}
