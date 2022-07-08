<?php

declare(strict_types=1);

namespace App\Domain\Post;

use JsonSerializable;
use App\Domain\Post\Validation\StringNotEmpty;
use Spatie\DataTransferObject\DataTransferObject;

class Post extends DataTransferObject implements JsonSerializable
{
    private ?int $id;

    #[StringNotEmpty]
    public string $title;

    #[StringNotEmpty]
    public string $body;

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