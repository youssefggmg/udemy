<?php
class Sanitizer
{
    public static function sanitizeString(string $input): string
    {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }
    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validatePassword(string $password): bool
    {
        // Example: Minimum 8 characters, at least one letter and one number.
        return preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password) === 1;
    }
    public static function validateUserType(string $userType): bool
    {
        $validUserTypes = ['Student', 'Teacher'];
        return in_array($userType, $validUserTypes, true);
    }
}
?>
