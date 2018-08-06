<?php
require_once 'SQL.php';

class UsersService
{
    private $connection;
    private $table = 'users';
    private $data;
    public $id;
    public $name;
    public $email;
    public $password;

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
        $users_array = array();
        $users_array['data'] = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $user = array(
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'password' => $password,
            );
            array_push($users_array['data'], $user);
        }

        return $users_array;
    }

    public function getOne($id)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $user = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => $row['password'],
        );

        return $user;
    }

    public function post()
    {
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        $this->data = json_decode(file_get_contents("php://input"));
        $this->name = $this->data->name;
        $this->email = $this->data->email;
        $this->password = $this->data->password;
        $query = 'INSERT INTO ' . $this->table . '
        SET name = :name,
            email = :email,
            password = :password';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':name', htmlspecialchars(strip_tags($this->name)));
        $stmt->bindParam(':email', htmlspecialchars(strip_tags($this->email)));
        $stmt->bindParam(':password', htmlspecialchars(strip_tags($this->password)));
        if ($stmt->execute()) {
            echo json_encode(array(
                'message' => 'User Created',
            ));
        } else {
            echo json_encode(array(
                'message' => 'User Not Created',
            ));
            printf("Error: %s.\n", $stmt->error);
        }
    }

    public function update($id)
    {
        header('Access-Control-Allow-Methods: PUT');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        $this->data = json_decode(file_get_contents("php://input"));
        $this->name = $this->data->name;
        $this->email = $this->data->email;
        $this->password = $this->data->password;
        $query = 'UPDATE ' . $this->table . '
            SET name = :name,
                email = :email,
                password = :password';
        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(':name', htmlspecialchars(strip_tags($this->name)));
        $stmt->bindParam(':email', htmlspecialchars(strip_tags($this->email)));
        $stmt->bindParam(':password', htmlspecialchars(strip_tags($this->password)));
        if ($stmt->execute()) {
            echo json_encode(array(
                'message' => 'User Updated',
            ));
        } else {
            echo json_encode(array(
                'message' => 'User Not Updated',
            ));
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
            echo json_encode(array(
                'message' => 'User Deleted',
            ));
        } else {
            echo json_encode(array(
                'message' => 'User Not Updated',
            ));
            printf("Error: %s.\n", $stmt->error);
        }
    }
}
