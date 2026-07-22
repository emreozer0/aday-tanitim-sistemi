<?php

class Database {
    private $host = "localhost";
    private $db_name = "aday_tanitim_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function baglan() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            // Hata olursa exception fırlatsın (görmemizi kolaylaştırır)
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Bağlantı hatası: " . $e->getMessage();
        }

        return $this->conn;
    }
}