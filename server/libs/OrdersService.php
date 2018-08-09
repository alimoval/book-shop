<?php
require_once 'SQL.php';

class OrdersService
{
    private $connection;
    public $table = 'orders';
    public $data;
    public $id;
    public $car_id;
    public $user_id;
    public $date;

    public function __construct()
    {
        $db = new SQL();
        $this->connection = $db->connect();
        // Check is User authorized
    }

    public function getAll()
    {
        $query = 'SELECT 
                o.id,
                o.date,
                c.model as car_model,
                u.name as user_name
            FROM ' . $this->table . ' o
            LEFT JOIN
                cars c ON o.car_id = c.id
            LEFT JOIN
                users u ON o.user_id = u.id';
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $users_array = array();
        $users_array['data'] = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $user = array(
                'id' => $id,
                'model' => $car_model,
                'name' => $user_name,
                'date' => $date,
            );
            array_push($users_array['data'], $user);
        }
        return $users_array;
    }

    public function getOne($id)
    {
        $query = 'SELECT 
                o.id,
                o.date,
                c.model as car_model,
                u.name as user_name
            FROM ' . $this->table . ' o
            LEFT JOIN
                cars c ON o.car_id = c.id
            LEFT JOIN
                users u ON o.user_id = u.id
            WHERE o.id = ?';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $user = array(
            'id' => $row['id'],
            'car' => $row['car_model'],
            'name' => $row['user_name'],
            'date' => $row['date'],
        );
        return $user;
    }

    public function post()
    {
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        $this->data = json_decode(file_get_contents("php://input"));
        $this->date = $this->data->date;
        $this->car_id = $this->data->car_id;
        $this->user_id = $this->data->user_id;
        $query = "INSERT INTO " . $this->table . " SET date = :date, car_id = :car_id, user_id = :user_id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':date', htmlspecialchars(strip_tags($this->date)));
        $stmt->bindParam(':car_id', htmlspecialchars(strip_tags($this->car_id)));
        $stmt->bindParam(':user_id', htmlspecialchars(strip_tags($this->user_id)));
        if ($stmt->execute()) {
            return array('message' => 'Order Created');
        } else {
            return array('message' => 'Order Not Created');
            printf("Error: %s.\n", $stmt->error);
        }
    }

    public function update($id)
    {
        header('Access-Control-Allow-Methods: PUT');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        $this->data = json_decode(file_get_contents("php://input"));
        $this->date = $this->data->date;
        $this->car_id = $this->data->car_id;
        $this->user_id = $this->data->user_id;
        $query = 'UPDATE ' . $this->table . '
            SET date = :date,
                car_id = :car_id,
                user_id = :user_id
                WHERE id = :id';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', htmlspecialchars(strip_tags($id)));
        $stmt->bindParam(':date', htmlspecialchars(strip_tags($this->date)));
        $stmt->bindParam(':car_id', htmlspecialchars(strip_tags($this->car_id)));
        $stmt->bindParam(':user_id', htmlspecialchars(strip_tags($this->user_id)));
        if ($stmt->execute()) {
            return array('message' => 'Order Updated');
        } else {
            return array('message' => 'Order Not Updated');
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
            return array('message' => 'Order Deleted');
        } else {
            return array('message' => 'Order Not Updated');
            printf("Error: %s.\n", $stmt->error);
        }
    }
}
