<?php
declare(strict_types=1);

namespace App\Domain\Post;

interface PostRepositoryInterface
{
    /**
     * List posts
     * 
     * @param array $params
     */
    public function list(array $params);

    /**
     * Store a new post
     * 
     * @param array $params
     */
    public function store(array $params);

    /**
     * Get a post via id
     * 
     * @param int $id
     */
    public function get(int $id);

    /**
     * Update a post via id
     * 
     * @param int $id
     * @param array $params
     */
    public function update(int $id, array $params);
}
