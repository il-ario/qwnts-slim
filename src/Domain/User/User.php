<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Validation\StringNotEmpty;
use Spatie\DataTransferObject\DataTransferObject;

class User extends DataTransferObject implements \JsonSerializable
{
    private ?int $id;

    #[StringNotEmpty]
    public string $givenName;

    #[StringNotEmpty]
    public string $familyName;

    #[StringNotEmpty]
    public string $email;

    #[StringNotEmpty]
    public string $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGivenName(): string
    {
        return $this->givenName;
    }

    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    public function getBirthDate(): \DateTime
    {
        return $this->birthDate;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
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
            'givenName' => $this->givenName,
            'familyName' => $this->familyName,
            'email' => $this->email,
            'birthDate' => $this->birthDate,
            'password' => $this->password,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}