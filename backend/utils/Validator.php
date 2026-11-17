<?php

require_once __DIR__ . '/exceptions.php';

class Validator
{
    /** Every field in $fields must exist and must not be empty. */
    public static function required($data, $fields)
    {
        foreach ($fields as $field) {
            if (!isset($data[$field]) || trim((string) $data[$field]) === '') {
                throw new ValidationException("Field '$field' is required.");
            }
        }
    }

    /** Validate the trimmed character length of a value. */
    public static function length($value, $field, $min, $max)
    {
        $length = mb_strlen(trim((string) $value));
        if ($length < $min || $length > $max) {
            throw new ValidationException("Field '$field' must be between $min and $max characters long.");
        }
    }

    /** Validate a whole number and optional bounds. */
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

    /** Validate that a value is one of the allowed values. */
    public static function one_of($value, $field, $allowed)
    {
        if (!in_array($value, $allowed, true)) {
            throw new ValidationException("Field '$field' must be one of: " . implode(', ', $allowed) . '.');
        }
    }

    /** Validate an e-mail address. */
    public static function email($value, $field = 'email')
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw new ValidationException("Field '$field' must be a valid email address.");
        }
    }

    /** Validate an absolute URL. */
    public static function url($value, $field)
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw new ValidationException("Field '$field' must be a valid URL.");
        }
    }

    /** Validate a date in YYYY-MM-DD format. */
    public static function date($value, $field)
    {
        $date = DateTime::createFromFormat('Y-m-d', (string) $value);
        if (!$date || $date->format('Y-m-d') !== $value) {
            throw new ValidationException("Field '$field' must be a date in the format YYYY-MM-DD.");
        }
    }

    /** Validate a MySQL date and time value. */
    public static function datetime($value, $field)
    {
        $date = DateTime::createFromFormat('Y-m-d H:i:s', (string) $value);
        if (!$date || $date->format('Y-m-d H:i:s') !== $value) {
            throw new ValidationException("Field '$field' must be a date and time in the format YYYY-MM-DD HH:MM.");
        }
    }

    /** Require at least eight characters, one letter, and one digit. */
    public static function password($value, $field = 'password')
    {
        if (
            mb_strlen((string) $value) < 8
            || !preg_match('/[A-Za-z]/', $value)
            || !preg_match('/\d/', $value)
        ) {
            throw new ValidationException("Field '$field' must have at least 8 characters, including a letter and a number.");
        }
    }
}
