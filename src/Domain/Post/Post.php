<?php

declare(strict_types=1);

namespace App\Domain\Post;

use JsonSerializable;

class Post implements JsonSerializable
{
    private ?int $id;

    private string $title;

    private string $body;

    private string $status;

    public function __construct(?int $id, string $title, string $body, string $status)
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->status = $status;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'status' => $this->status,
        ];
    }
}