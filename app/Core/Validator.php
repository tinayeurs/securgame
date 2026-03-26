<?php

declare(strict_types=1);

namespace App\Core;

final class Validator
{
    public static function email(string $email): bool
    {
        return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function required(?string $value): bool
    {
        return is_string($value) && trim($value) !== '';
    }
}
