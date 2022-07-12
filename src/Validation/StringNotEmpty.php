<?php

declare(strict_types=1);

namespace App\Validation;

use Attribute;
use Spatie\DataTransferObject\Validator;
use Spatie\DataTransferObject\Validation\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class StringNotEmpty implements Validator
{
    public function validate(mixed $value): ValidationResult
    {
        var_dump($value);
        if ($value == null || $value == '') {
            return ValidationResult::invalid("Value cannot be empty");
        }

        return ValidationResult::valid();
    }
}
