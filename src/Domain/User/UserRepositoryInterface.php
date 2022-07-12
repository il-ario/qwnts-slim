<?php
declare(strict_types=1);

namespace App\Domain\User;

interface UserRepositoryInterface
{
    /**
     * List users
     * 
     * @param array $params
     */
    public function list(array $params);

    /**
     * Store a new user
     * 
     * @param array $params
     */
    public function store(array $params);

    /**
     * Get a user via id
     * 
     * @param string $email
     */
    public function get(int $id);

    /**
     * Get a user via email
     * 
     * @param string $email
     */
    public function getEmail(string $email);

    /**
     * Update a user via email
     * 
     * @param string $email
     * @param array $params
     */
    public function update(string $email, array $params);

    /**
     * Delete a user via email
     * 
     * @param string $email
     */
    public function delete(string $email);
}
