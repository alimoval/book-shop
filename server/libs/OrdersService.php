<?php

class OrdersService
{
    private $connection;
    public $table = 'orders';
    public $data;
    public $id;
    public $book_id;
    public $user_id;
    public $date;
    public $price;

    public function __construct()
    {
        $db = new SQL();
        $this->connection = $db->connect();
    }

    public function getAll()
    {
        $query = 'SELECT 
                o.id,
                o.date,
                b.name as book_name,
                u.name as user_name
            FROM ' . $this->table . ' o
            LEFT JOIN
                books b ON o.book_id = b.id
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
                'book_name' => $book_name,
                'user_name' => $user_name,
                'date' => $date,
            );
            array_push($users_array['data'], $user);
        }
        return $users_array;
    }

    public function getAllFiltered($arg)
    {
        list($param, $value) = explode("=", $arg);
        $query = 'SELECT 
                o.id,
                o.date,
                b.name as book_name,
                u.name as user_name
            FROM ' . $this->table . ' o 
            LEFT JOIN
                books b ON o.book_id = b.id
            LEFT JOIN
                users u ON o.user_id = u.id 
            WHERE u.id = ?';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $value);
        $stmt->execute();
        $users_array = array();
        $users_array['data'] = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $user = array(
                'id' => $id,
                'book_name' => $book_name,
                'user_name' => $user_name,
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
                b.name as book_name,
                b.price as book_price,
                u.name as user_name
            FROM ' . $this->table . ' o
            LEFT JOIN
                books b ON o.book_id = b.id
            LEFT JOIN
                users u ON o.user_id = u.id
            WHERE o.id = ?';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $orders_array = array();
        $orders_array['data'] = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $order = array(
                'id' => $id,
                'book_name' => $book_name,
                'user_name' => $user_name,
                'price' => $book_price,
                'date' => $date,
            );
            array_push($orders_array['data'], $order);
        }
        return $orders_array;
    }

    public function post()
    {
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        $this->data = json_decode(file_get_contents("php://input"));
        $this->date = $this->data->date;
        $this->book_id = $this->data->book_id;
        $this->user_id = $this->data->user_id;
        $this->price = $this->data->price;
        $query = "INSERT INTO " . $this->table . " 
                SET date = :date, 
                book_id = :book_id, 
                user_id = :user_id,
                price = :price";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':date', htmlspecialchars(strip_tags($this->date)));
        $stmt->bindParam(':book_id', htmlspecialchars(strip_tags($this->book_id)));
        $stmt->bindParam(':user_id', htmlspecialchars(strip_tags($this->user_id)));
        $stmt->bindParam(':price', htmlspecialchars(strip_tags($this->price)));
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
        $this->book_id = $this->data->book_id;
        $this->user_id = $this->data->user_id;
        $this->price = $this->data->price;
        $query = 'UPDATE ' . $this->table . '
            SET date = :date,
                book_id = :book_id,
                user_id = :user_id,
                price = :price,
                WHERE id = :id';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', htmlspecialchars(strip_tags($id)));
        $stmt->bindParam(':date', htmlspecialchars(strip_tags($this->date)));
        $stmt->bindParam(':book_id', htmlspecialchars(strip_tags($this->book_id)));
        $stmt->bindParam(':user_id', htmlspecialchars(strip_tags($this->user_id)));
        $stmt->bindParam(':price', htmlspecialchars(strip_tags($this->price)));
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
