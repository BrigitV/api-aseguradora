<?php
require_once __DIR__.'/../../env-loader.php';

class Database {
    private $conn;

    public function __construct() {
        $this->validateEnvironment();
    }

    private function validateEnvironment() {
        $requiredVars = ['DB_HOST', 'DB_NAME', 'DB_USER'];
        foreach ($requiredVars as $var) {
            if (getenv($var) === false) {
                throw new RuntimeException("La variable de entorno $var no está configurada");
            }
        }
    
        // DB_PASS puede estar vacío, pero debe existir
        if (getenv('DB_PASS') === false) {
            throw new RuntimeException("La variable de entorno DB_PASS no está configurada");
        }
    }

    public function getConnection() {
        if ($this->conn === null) {
            $this->connect();
        }
        return $this->conn;
    }

    private function connect() {
        try {
            $dsn = $this->buildDsn();
            $this->conn = new PDO(
                $dsn,
                getenv('DB_USER'),
                getenv('DB_PASS')
            );
        } catch (PDOException $e) {
            error_log("Error PDO: " . $e->getMessage());
            throw new RuntimeException("Error al conectar con la base de datos. Código: " . $e->getCode());
        }
    }
    
    private function buildDsn() {
        return sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            getenv('DB_HOST'),
            getenv('DB_PORT') ?: '3306',
            getenv('DB_NAME'),
            getenv('DB_CHARSET') ?: 'utf8mb4'
        );
    }
}