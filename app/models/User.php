<?php
// for some unKnown reason, the code is not working as expected uless I included the files this way 
include "C:/xampp/htdocs/YoudmyMVC/app/Helpers/signUpSanitze.php";

class User
{
    protected ?int $id = null;
    protected ?string $name = null;
    protected ?string $email = null;
    private ?string $password = null;
    protected ?string $user_type = null;
    protected $db;

    public function __construct($id = null, $user_type = null, $name = null, $email = null,  $password = null)
    {
        $this->db = Database::getInstance();
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->user_type = $user_type;
    }
    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function signUp(string $name, string $email, string $password, string $user_type): array
    {
        $name = Sanitizer::sanitizeString($name);
        $email = Sanitizer::sanitizeString($email);
        if (!Sanitizer::validateEmail($email)) {
            return ['status' => 0, 'message' => 'Invalid email address.'];
        }

        if (!Sanitizer::validatePassword($password)) {
            return ['status' => 0, 'message' => 'Password must be at least 8 characters long and contain at least one letter and one number.'];
        }

        if (!Sanitizer::validateUserType($user_type)) {
            return ['status' => 0, 'message' => 'Invalid user type.'];
        }
        try {
            $this->db->query('SELECT id FROM "User" WHERE email = :email');
            $this->db->bind(':email', $email);
            $this->db->execute();

            if ($this->db->single()) {
                return ['status' => 0, 'message' => 'Email already exists.'];
            }
            $accountStatus = ($user_type === 'Student') ? 'Active' : 'Inactive';
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
                'user_type' => $user_type,
                'account_status' => $accountStatus
            ];

            if ($this->db->insert('"User"', $data)) {
                return ['status' => 1, 'message' => new User($this->db->lastInsertId(),$user_type)];
            }
            return ['status' => 0, 'message' => 'Registration failed.'];
        } catch (PDOException $e) {
            die("dkjgfkjgsdfgdhgf");
            // return ['status' => 0, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function logIn(string $email, string $password): array
    {
        if (!Sanitizer::validateEmail($email)) {
            return ['status' => 0, 'message' => 'Invalid email address.'];
        }

        if (!Sanitizer::validatePassword($password)) {
            return ['status' => 0, 'message' => 'Password must be at least 8 characters long and contain at least one letter and one number.'];
        }
        try {
            $this->db->query('SELECT * FROM "User" WHERE email = :email');
            $this->db->bind(':email', $email);
            $this->db->execute();
            $user = $this->db->single();

            if (!$user) {
                return ['status' => 0, 'message' => 'Email not found.'];
            }
            if (password_verify($password, $user['password'])) {
                return ['status' => 1, 'message' => [new User($user['id'], $user['name'], $user['email'], $user['user_type'])]];
            }
            return ['status' => 0, 'message' => 'Invalid email or password.'];
        } catch (PDOException $e) {
            return ['status' => 0, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
}
