<?php

declare(strict_types=1);

namespace App\Domain\Post;

use App\Validation\StringNotEmpty;
use App\Validation\ValidPostStatus;
use Spatie\DataTransferObject\DataTransferObject;

class Post extends DataTransferObject implements \JsonSerializable
{
    private ?int $id;

    #[StringNotEmpty]
    public string $title;

    #[StringNotEmpty]
    public string $body;

    #[StringNotEmpty]
    #[ValidPostStatus]
    public string $status;

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

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt
        ];
    }
}