<?php

declare(strict_types=1);

namespace App\Validation;

use Attribute;
use Spatie\DataTransferObject\Validator;
use Spatie\DataTransferObject\Validation\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class ValidPostStatus implements Validator
{
    private array $enums;

    public function __construct()
    {
        $this->enums = ['offline', 'online'];
    }
    
    public function validate(mixed $value): ValidationResult
    {
        if (! in_array($value, $this->enums)) {
            return ValidationResult::invalid("Incorrect data.");
        }

        return ValidationResult::valid();
    }
}
