<?php
require_once 'SQL.php';

class CarsService
{
    private $conn;
    private $table = 'cars';

    public $id;
    public $model;
    public $tm;
    public $price;
    public $color;
    public $year;
    public $gas;
    public $odo;
    public $engine;
    public $town;
    public $images;

    public function __construct()
    {
        $db = new SQL();
        $this->conn = $db->connect();
    }

    public function getCars()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getCar($id)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->model = $row['model'];
        $this->tm = $row['tm'];
        $this->price = $row['price'];
        $this->color = $row['color'];
        $this->year = $row['year'];
        $this->gas = $row['gas'];
        $this->odo = $row['odo'];
        $this->engine = $row['engine'];
        $this->town = $row['town'];
        $this->images = $row['images'];
    }
}
