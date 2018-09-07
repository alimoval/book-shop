<?php

class AuthorsService
{
    private $table = 'authors';
    private $connection;
    private $authorId;

    public function __construct()
    {
        $db = new SQL();
        $this->connection = $db->connect();
    }

    public function getAll()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $authors_array = array();
        $authors_array['data'] = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $author = array(
                'id' => $id,
                'name' => $name
            );
            array_push($authors_array['data'], $author);
        }
        $collection = Collection::fromRawData($authors_array, Author::class);

        return $collection;
    }

    public function getOne($id)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $authors_array = array();
        $authors_array['data'] = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $author = array(
                'id' => $id,
                'name' => $name
            );
            array_push($authors_array['data'], $author);
        }
        $collection = Collection::fromRawData($authors_array, Author::class);

        return $collection;
    }

    public function post()
    {
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        $this->data = json_decode(file_get_contents("php://input"));
        $this->name = $this->data->name;
        $query = 'INSERT INTO ' . $this->table . '
                SET name = :name';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':name', htmlspecialchars(strip_tags($this->name)));
        if ($stmt->execute()) {
            $this->authorId = $this->connection->lastInsertId();
            return array('message' => 'Author ' . $this->authorId . ' Created');
        } else {
            return array('message' => 'Author Not Created');
            printf("Error: %s.\n", $stmt->error);
        }
    }

    public function update($id)
    {
        header('Access-Control-Allow-Methods: PUT');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        $this->data = json_decode(file_get_contents("php://input"));
        $this->name = $this->data->name;
        $query = 'UPDATE ' . $this->table . '
                SET name = :name
                WHERE id = :id';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':name', htmlspecialchars(strip_tags($this->name)));
        $stmt->bindParam(':id', htmlspecialchars(strip_tags($id)));
        $this->authorId = $id;
        if ($stmt->execute()) {
            return array('message' => 'Author ' . $this->authorId . ' Updated');
        } else {
            return array('message' => 'Author ' . $this->authorId . ' Not Updated');
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
        $this->authorId = $id;
        if ($stmt->execute()) {
            return array('message' => 'Author ' . $this->authorId . ' Deleted');
        } else {
            return array('message' => 'Author ' . $this->authorId . ' Not Updated');
            printf("Error: %s.\n", $stmt->error);
        }
    }
}
