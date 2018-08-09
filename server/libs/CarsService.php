<?php
require_once 'SQL.php';

class CarsService
{
    private $connection;
    private $table = 'cars';
    private $data;
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
        $this->connection = $db->connect();
        // Check is User authorized
    }

    public function getAll()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $cars_array = array();
        $cars_array['data'] = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $car = array(
                'id' => $id,
                'model' => $model,
                'tm' => $tm,
                'price' => $price,
                'color' => $color,
                'year' => $year,
                'gas' => $gas,
                'odo' => $odo,
                'engine' => $engine,
                'town' => $town,
                'images' => $images,
            );
            array_push($cars_array['data'], $car);
        }
        return $cars_array;
    }

    public function getOne($id)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $car = array(
            'id' => $row['id'],
            'model' => $row['model'],
            'tm' => $row['tm'],
            'price' => $row['price'],
            'color' => $row['color'],
            'year' => $row['year'],
            'gas' => $row['gas'],
            'odo' => $row['odo'],
            'engine' => $row['engine'],
            'town' => $row['town'],
            'images' => $row['images'],
        );
        return $car;
    }

    public function post()
    {
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        $this->data = json_decode(file_get_contents("php://input"));
        $this->model = $this->data->model;
        $this->tm = $this->data->tm;
        $this->price = $this->data->price;
        $this->color = $this->data->color;
        $this->year = $this->data->year;
        $this->gas = $this->data->gas;
        $this->odo = $this->data->odo;
        $this->engine = $this->data->engine;
        $this->town = $this->data->town;
        $this->images = $this->data->images;
        $query = 'INSERT INTO ' . $this->table . '
        SET model = :model,
            tm = :tm,
            price = :price,
            color = :color,
            year = :year,
            gas = :gas,
            odo = :odo,
            engine = :engine,
            town = :town,
            images = :images';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':model', htmlspecialchars(strip_tags($this->model)));
        $stmt->bindParam(':tm', htmlspecialchars(strip_tags($this->tm)));
        $stmt->bindParam(':price', htmlspecialchars(strip_tags($this->price)));
        $stmt->bindParam(':color', htmlspecialchars(strip_tags($this->color)));
        $stmt->bindParam(':year', htmlspecialchars(strip_tags($this->year)));
        $stmt->bindParam(':gas', htmlspecialchars(strip_tags($this->gas)));
        $stmt->bindParam(':odo', htmlspecialchars(strip_tags($this->odo)));
        $stmt->bindParam(':engine', htmlspecialchars(strip_tags($this->engine)));
        $stmt->bindParam(':town', htmlspecialchars(strip_tags($this->town)));
        $stmt->bindParam(':images', htmlspecialchars(strip_tags($this->images)));
        if ($stmt->execute()) {
            return array('message' => 'Car Created');
        } else {
            return array('message' => 'Car Not Created');
            printf("Error: %s.\n", $stmt->error);
        }
    }

    public function update($id)
    {
        header('Access-Control-Allow-Methods: PUT');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        $this->data = json_decode(file_get_contents("php://input"));
        $this->model = $this->data->model;
        $this->tm = $this->data->tm;
        $this->price = $this->data->price;
        $this->color = $this->data->color;
        $this->year = $this->data->year;
        $this->gas = $this->data->gas;
        $this->odo = $this->data->odo;
        $this->engine = $this->data->engine;
        $this->town = $this->data->town;
        $this->images = $this->data->images;
        $query = 'UPDATE ' . $this->table . '
        SET model = :model,
            tm = :tm,
            price = :price,
            color = :color,
            year = :year,
            gas = :gas,
            odo = :odo,
            engine = :engine,
            town = :town,
            images = :images
            WHERE id = :id';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':model', htmlspecialchars(strip_tags($this->model)));
        $stmt->bindParam(':tm', htmlspecialchars(strip_tags($this->tm)));
        $stmt->bindParam(':price', htmlspecialchars(strip_tags($this->price)));
        $stmt->bindParam(':color', htmlspecialchars(strip_tags($this->color)));
        $stmt->bindParam(':year', htmlspecialchars(strip_tags($this->year)));
        $stmt->bindParam(':gas', htmlspecialchars(strip_tags($this->gas)));
        $stmt->bindParam(':odo', htmlspecialchars(strip_tags($this->odo)));
        $stmt->bindParam(':engine', htmlspecialchars(strip_tags($this->engine)));
        $stmt->bindParam(':town', htmlspecialchars(strip_tags($this->town)));
        $stmt->bindParam(':images', htmlspecialchars(strip_tags($this->images)));
        $stmt->bindParam(':id', htmlspecialchars(strip_tags($id)));
        if ($stmt->execute()) {
            return array('message' => 'Car Updated');
        } else {
            return array('message' => 'Car Not Updated');
            printf("Error: %s.\n", $stmt->error);
        }
    }

    public function delete($id)
    {
        header('Access-Control-Allow-Methods: DELETE');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        if ($stmt->execute()) {
            return array('message' => 'Car Deleted');
        } else {
            return array('message' => 'Car Not Updated');
            printf("Error: %s.\n", $stmt->error);
        }
    }
}
