<?php
declare(strict_types=1);

namespace App\Domain\User;

use Doctrine\DBAL\Connection;

class UserRepository implements UserRepositoryInterface
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
     * List users
     * 
     * @param array $params
     */
    public function list(array $params)
    {
        $statement = "SELECT * FROM users";
        
        /**
         * If sort options are present, compose the query statement
         */
        if (array_key_exists('sort', $params)) {
            $length = count($params['sort']);
            $statement .= " ORDER BY ";
            
            foreach ($params['sort'] as $key => $value) {
                $statement .= substr($value, 1);

                if (substr($value, 0, 1) === '-') {
                    $statement .= " DESC ";
                } else {
                    $statement .= " ASC ";
                }

                if (! $key == $length) {
                    $statement .= ", ";
                }
            }
        }

        $query = $this->connection->prepare($statement);
        $data = $query->executeQuery()->fetchAllAssociative();

        return $data;
    }

    /**
     * Store a new user
     * 
     * @param array $params
     */
    public function store(array $params)
    {
        $this->connection->insert('users', [
            'givenName' => $params['givenName'],
            'familyName' => $params['familyName'],
            'email' => $params['email'],
            'birthDate' => $params['birthDate'],
            'password' => $params['password'],
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ]);

        return $this->connection->lastInsertId();
    }

    /**
     * Get a user via id
     * 
     * @param string $id
     */
    public function get(int $id)
    {
        $statement = "SELECT * FROM users WHERE id = '$id'";

        $query = $this->connection->prepare($statement);
        $data = $query->executeQuery()->fetchAllAssociative();

        return $data;
    }

    /**
     * Get a user
     * 
     * @param string $email
     */
    public function getEmail(string $email)
    {
        $statement = "SELECT * FROM users WHERE email = '$email'";

        $query = $this->connection->prepare($statement);
        $data = $query->executeQuery()->fetchAllAssociative();

        return $data;
    }

    /**
     * Update a user via email
     * 
     * @param string $email
     * @param array $params
     */
    public function update(string $email, array $params)
    {
        $data = $this->connection->update('users', [
            'givenName' => $params['givenName'],
            'familyName' => $params['familyName'],
            'email' => $params['email'],
            'birthDate' => $params['birthDate'],
            'password' => $params['password'],
            'updatedAt' => date('Y-m-d H:i:s'),
        ], [
            'email' => $email
        ]);

        return $data;
    }

    /**
     * Delete a user via email
     * 
     * @param string $email
     */
    public function delete(string $email)
    {
        $statement = "DELETE FROM users WHERE email = '$email'";

        $query = $this->connection->prepare($statement);
        $data = $query->executeQuery();

        return $data;
    }
}
