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

// INSERT INTO `cars`(`id`, `model`, `tm`, `price`, `color`, `year`, `gas`, `odo`, `engine`, `town`, `images`) VALUES (2, 'Micra', 'Nissan', 7000, 'silver', '2007', 'gasoline', '160000', '1400', 'Mykolaiv','https://cdn4.riastatic.com/photosnew/auto/photo/nissan_micra__243070814fx.webp')
