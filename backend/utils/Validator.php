<?php

require_once __DIR__ . '/exceptions.php';

class Validator
{
    public static function required($data, $fields)
    {
        foreach ($fields as $field) {
            if (!isset($data[$field]) || trim((string) $data[$field]) === '') {
                throw new ValidationException("Field '$field' is required.");
            }
        }
    }

    public static function length($value, $field, $min, $max)
    {
        $length = mb_strlen(trim((string) $value));
        if ($length < $min || $length > $max) {
            throw new ValidationException("Field '$field' must be between $min and $max characters long.");
        }
    }

    public static function integer($value, $field, $min = null, $max = null)
    {
        if (filter_var($value, FILTER_VALIDATE_INT) === false) {
            throw new ValidationException("Field '$field' must be a whole number.");
        }
        if ($min !== null && (int) $value < $min) {
            throw new ValidationException("Field '$field' must be at least $min.");
        }
        if ($max !== null && (int) $value > $max) {
            throw new ValidationException("Field '$field' must be at most $max.");
        }
    }

    public static function in($value, $field, $allowed)
    {
        if (!in_array($value, $allowed, true)) {
            throw new ValidationException("Field '$field' must be one of: " . implode(', ', $allowed) . '.');
        }
    }

    public static function email($value, $field = 'email')
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw new ValidationException("Field '$field' must be a valid e-mail address.");
        }
    }

    public static function url($value, $field)
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw new ValidationException("Field '$field' must be a valid URL.");
        }
    }
}
