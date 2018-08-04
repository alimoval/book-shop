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
    }

    public function getCars()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        $cars_array = array();
        $cars_array['data'] = array();

        // $num = $result->rowCount();

        //     if ($num > 0) {
        //     } else {
        //         echo json_encode(array('message' => 'No cars found'));
        //     }

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

    public function getCar($id)
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

    public function postCar()
    {
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
        
        $this->model = htmlspecialchars(strip_tags($this->model));
        $this->tm = htmlspecialchars(strip_tags($this->tm));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->gas = htmlspecialchars(strip_tags($this->gas));
        $this->odo = htmlspecialchars(strip_tags($this->odo));
        $this->engine = htmlspecialchars(strip_tags($this->engine));
        $this->town = htmlspecialchars(strip_tags($this->town));
        $this->images = htmlspecialchars(strip_tags($this->images));

        $stmt->bindParam(':model', $this->model);
        $stmt->bindParam(':tm', $this->tm);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':color', $this->color);
        $stmt->bindParam(':year', $this->year);
        $stmt->bindParam(':gas', $this->gas);
        $stmt->bindParam(':odo', $this->odo);
        $stmt->bindParam(':engine', $this->engine);
        $stmt->bindParam(':town', $this->town);
        $stmt->bindParam(':images', $this->images);

        if($stmt->execute()){
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;

        // {
        //     "model": "Gets",
        //     "tm": "Hyndai",
        //     "price": "6000",
        //     "color": "gold",
        //     "year": "2006",
        //     "gas": "gas",
        //     "odo": "180000",
        //     "engine": "1400",
        //     "town": "Mykolaiv",
        //     "images": "https://cdn1.riastatic.com/photosnew/auto/photo/hyundai_getz__243708576fx.webp"
        // }
    }
}
