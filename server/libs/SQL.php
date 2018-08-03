<?php

class SQL
{
    private $host = 'localhost';
    private $db_name = 'rest';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host='. $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}

// INSERT INTO `cars`(`id`, `model`, `tm`, `price`, `color`, `year`, `gas`, `odo`, `engine`, `town`, `images`) VALUES (1, 'Civic', 'Honda', 9000, 'black', '2008', 'gas', 'Mykolaiv','https://cdn4.riastatic.com/photosnew/auto/photo/honda_civic__242203354fx.webp')
