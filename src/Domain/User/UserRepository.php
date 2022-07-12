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
        $data = $query->executeQuery();

        return $data;
    }

    /**
     * Store a new user
     * 
     * @param array $params
     */
    public function store(array $params)
    {
        $statement = "INSERT INTO users (givenName, familyName, email, birthDate, password, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $query = $this->connection->prepare($statement);
        $query->bindValue(1, $params['givenName']);
        $query->bindValue(2, $params['familyName']);
        $query->bindValue(3, $params['email']);
        $query->bindValue(4, $params['birthDate']);
        $query->bindValue(5, sha1($params['password']));
        $query->bindValue(6, date('Y-m-d H:i:s'));
        $query->bindValue(7, date('Y-m-d H:i:s'));
        $data = $query->executeQuery();

        return $data;
    }

    /**
     * Get a user via email
     * 
     * @param string $email
     */
    public function get(string $email)
    {
        $statement = "SELECT * FROM users WHERE email = '$email'";

        $query = $this->connection->prepare($statement);
        $data = $query->executeQuery();

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
        $statement = "UPDATE users SET givenName = ?, familyName = ?, email = ?, birthDate = ?, password = ?, updatedAt = ? WHERE email = '$email'";
        
        $query = $this->connection->prepare($statement);
        $query->bindValue(1, $params['givenName']);
        $query->bindValue(2, $params['familyName']);
        $query->bindValue(3, $params['email']);
        $query->bindValue(4, $params['birthDate']);
        $query->bindValue(5, sha1($params['password']));
        $query->bindValue(6, date('Y-m-d H:i:s'));
        $data = $query->executeQuery();

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
