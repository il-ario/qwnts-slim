<?php
declare(strict_types=1);

namespace App\Domain\User;

use PDO;

class UserRepository
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
     * List users
     * 
     * @param array $params
     */
    public function list(array $params)
    {
        $statement = 'SELECT * FROM users';

        /**
         * If sort options are present, compose the query statement
         */
        if (array_key_exists('sort', $params)) {
            $length = count($params['sort']);
            $statement .= ' ORDER BY ';
            
            foreach ($params['sort'] as $key => $value) {
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

        $query = $this->connection->query($statement);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * Store a new user
     * 
     * @param array $params
     */
    public function store(array $params)
    {
        $query = $this->connection->prepare('INSERT INTO users (givenName, familyName, email, birthDate, password) VALUES (?, ?, ?, ?, ?)');
        $data = $query->execute([
            $params['givenName'],
            $params['familyName'],
            $params['email'],
            $params['birthDate'],
            sha1($params['password'])
        ]);

        return $data;
    }

    /**
     * Get a user via email
     * 
     * @param string $email
     */
    public function view(string $email)
    {
        $query = $this->connection->prepare("SELECT * FROM users WHERE email = '$email'");
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

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
        $query = $this->connection->prepare("UPDATE users SET givenName = ?, familyName = ?, email = ?, birthDate = ?, password = ? WHERE email = '$email'");
        $data = $query->execute([
            $params['givenName'],
            $params['familyName'],
            $params['email'],
            $params['birthDate'],
            sha1($params['password'])
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
        $query = $this->connection->prepare("DELETE FROM users WHERE email = '$email'");
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }
}
