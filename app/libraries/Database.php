<?php

class Database
{
    private static $instance = null;
    private $conn;
    private $stmt;

    private $host = 'localhost';
    private $user = 'postgres';
    private $password = '123';
    private $database = 'youdemyV2';

    private $port = 3307;

    private static $ERRMODE_EXCEPTION = PDO::ERRMODE_EXCEPTION;
    private static $FETCH_MODE = PDO::FETCH_ASSOC;

    private function __construct()
    {
        $dsn = "pgsql:host=$this->host;port=$this->port;dbname=$this->database";

        try {
            $this->conn = new PDO($dsn, $this->user, $this->password, );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, self::$ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, self::$FETCH_MODE);
        } catch (PDOException $e) {
            die("There was a problem with the database connection." . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function query($sql)
    {
        $this->stmt = $this->conn->prepare($sql);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            $type = $this->getPDOType($value);
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    private function getPDOType($value)
    {
        switch (true) {
            case is_int($value):
                return PDO::PARAM_INT;
            case is_bool($value):
                return PDO::PARAM_BOOL;
            case is_null($value):
                return PDO::PARAM_NULL;
            default:
                return PDO::PARAM_STR;
        }
    }

    public function execute()
    {
        try {
            return $this->stmt->execute();
        } catch (PDOException $e) {
            die("There was a problem with the query execution." . $e->getMessage());
        }
    }

    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch();
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    public function count($tableName)
    {
        $sql = "SELECT COUNT(*) FROM $tableName";
        $this->query($sql);
        return $this->single();
    }

    public function insert($table, $data)
    {
        try {
            $fields = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));

            $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
            $this->query($sql);

            foreach ($data as $param => $value) {
                $this->bind(":$param", $value);
            }

            return $this->execute();
        } catch (PDOException $e) {
            die("dkjgfkjgsdfgdhgf");
        }
    }
}

?>