<?php
declare(strict_types=1);

namespace App\Domain\Post;

use PDO;

class PostRepository
{
    /**
     * @var PDO
     */
    protected PDO $connection;

    /**
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
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
            $query = $this->connection->query("SELECT * FROM posts WHERE title LIKE '%$q%' OR body LIKE '%$q%'");
        } else {
            $query = $this->connection->query('SELECT * FROM posts');
        }
        
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * Store a new post
     * 
     * @param array $params
     */
    public function store(array $params)
    {
        $query = $this->connection->prepare('INSERT INTO posts (title, body, status) VALUES (?, ?, ?)');
        $data = $query->execute([
            $params['title'],
            $params['body'],
            $params['status']
        ]);

        return $data;
    }

    /**
     * Get a post via id
     * 
     * @param int $id
     */
    public function view(int $id)
    {
        $query = $this->connection->prepare("SELECT * FROM posts WHERE id = '$id'");
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

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
        $query = $this->connection->prepare("UPDATE posts SET title = ?, body = ?, status = ? WHERE id = $id");
        $data = $query->execute([
            $params['title'],
            $params['body'],
            $params['status']
        ]);

        return $data;
    }
}
