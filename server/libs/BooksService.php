<?php

class BooksService
{
    private $db;
    private $queryFilters;
    private $mailer;
    private $table = 'books';

    public function __construct()
    {
        $db = new SQL();
        $this->connection = $db->connect();
        $this->queryFilters = new QueryFilters();
    }

    public function getAll()
    {
        $query = 'SELECT books.id as id, books.name as name, books.price as price, books.description as description, genres.name as genre, authors.name as author
                    FROM ' . $this->table . ' as books ' .
                    'LEFT JOIN book_author_relation ON books.id=book_author_relation.book_id
                    LEFT JOIN authors ON authors.id=book_author_relation.author_id
                    LEFT JOIN book_genre_relation ON books.id=book_genre_relation.book_id
                    LEFT JOIN genres ON genres.id=book_genre_relation.genre_id';
        $whereClause = [];
        $params = [];
        // conditions whether authors or genres selected
        if ($this->queryFilters->hasFilter('authors')) {
            $inClause = str_repeat('?,', count($this->queryFilters->getAuthors()) - 1) . '?';
            $whereClause[] = "book_author_relation.author_id IN($inClause)";
            $params = $this->queryFilters->getAuthors();
        }
        if ($this->queryFilters->hasFilter('genres')) {
            $inClause = str_repeat('?,', count($this->queryFilters->getGenres()) - 1) . '?';
            $whereClause[] = "book_genre_relation.genre_id IN($inClause)";
            $params = array_merge($params, $this->queryFilters->getGenres());
        }
        if ($whereClause) {
            $query .= " WHERE " . implode('AND ', $whereClause);
        }
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $books_array = array();
        $books_array['data'] = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $book = array(
                'id' => $id,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'genre' => $genre,
                'author' => $author,
            );
            array_push($books_array['data'], $book);
        }
        $collection = Collection::fromRawData($books_array, Book::class);

        return $collection;
    }

    public function getOne($id)
    {
        $query = 'SELECT books.id as id, books.name as name, books.price as price, books.description as description, genres.name as genre, authors.name as author
                    FROM ' . $this->table . ' as books ' .
            'LEFT JOIN book_author_relation ON books.id=book_author_relation.book_id
                    LEFT JOIN authors ON authors.id=book_author_relation.author_id
                    LEFT JOIN book_genre_relation ON books.id=book_genre_relation.book_id
                    LEFT JOIN genres ON genres.id=book_genre_relation.genre_id WHERE books.id = ?';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $books_array = array();
        $books_array['data'] = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $book = array(
                'id' => $id,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'genre' => $genre,
                'author' => $author,
            );
            array_push($books_array['data'], $book);
        }
        $collection = Collection::fromRawData($books_array, Book::class);

        return $collection;
    }

    public function post()
    {
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        print_r($this->data = json_decode(file_get_contents("php://input")));
        $this->name = $this->data->name;
        $this->description = $this->data->description;
        $this->price = $this->data->price;
        $query = 'INSERT INTO ' . $this->table . '
        SET name = :name,
            description = :description,
            price = :price';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':name', htmlspecialchars(strip_tags($this->name)));
        $stmt->bindParam(':description', htmlspecialchars(strip_tags($this->description)));
        $stmt->bindParam(':price', htmlspecialchars(strip_tags($this->price)));
        if ($stmt->execute()) {
            $id =  $this->insertRelations();
            return array('message' => 'Book ' . $id . ' Created');
        } else {
            return array('message' => 'Book Not Created');
            printf("Error: %s.\n", $stmt->error);
        }
    }

    public function insertRelations(Book $book)
    {
        if (!empty($book->getAuthors())) {
            // delete all book_author relations
            $this->db->delete('book_author_relation', ['book_id' => $bookId]);
            // add new ones
            foreach ($book->getAuthors() as $authorId) {
                $this->db->insert('book_author_relation', ['book_id' => $bookId, 'author_id' => $authorId]);
            }
        }

        // handle genres
        if (!empty($book->getGenres())) {
            // delete all book_author relations
            $this->db->delete('book_genre_relation', ['book_id' => $bookId]);
            // add new ones
            foreach ($book->getGenres() as $genreId) {
                $this->db->insert('book_genre_relation', ['book_id' => $bookId, 'genre_id' => $genreId]);
            }
        }

        return $bookId;
    }



    // public function insert()
    // {
        // $params = [
            //         'name'        => $book->getName(),
            //         'description' => $book->getDescription(),
            //         'price'       => $book->getPrice(),
            //     ];
    //     $query = sprintf("INSERT INTO %s ", $table);

    //     $placeholders = str_repeat('?,', count($params) - 1) . '?';
    //     $query        .= sprintf("(%s) ", implode(', ', array_keys($params)));
    //     $query        .= sprintf("VALUES (%s)", $placeholders);

    //     $stmt = $this->connection->prepare($query);
    //     $stmt->execute(array_values($params));

    //     return (int) $this->connection->lastInsertId();
    // }

    public function update($id)
    {
        header('Access-Control-Allow-Methods: PUT');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        $this->data = json_decode(file_get_contents("php://input"));
        $this->name = $this->data->name;
        $this->description = $this->data->description;
        $this->price = $this->data->price;
        $query = 'UPDATE ' . $this->table . '
        SET name = :name,
            description = :description,
            price = :price,
            WHERE id = :id';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':name', htmlspecialchars(strip_tags($this->model)));
        $stmt->bindParam(':description', htmlspecialchars(strip_tags($this->description)));
        $stmt->bindParam(':price', htmlspecialchars(strip_tags($this->price)));
        $stmt->bindParam(':id', htmlspecialchars(strip_tags($id)));
        if ($stmt->execute()) {
            return array('message' => 'Book Updated');
        } else {
            return array('message' => 'Book Not Updated');
            printf("Error: %s.\n", $stmt->error);
        }
    }


    // public function update(string $table, int $id, array $params)
    // {
    //     $placeholders = array_map(
    //         function ($field) {
    //             return "$field=?";
    //         },
    //         array_keys($params)
    //     );

    //     $assignmentList = implode(', ', $placeholders);

    //     $query          = sprintf("UPDATE %s SET %s WHERE id=? LIMIT 1", $table, $assignmentList);
    //     $queryParams    = array_values($params);
    //     $queryParams [] = $id;

    //     $stmt = $this->connection->prepare($query);
    //     $stmt->execute($queryParams);

    //     return $id;
    // }

    public function delete($id)
    {
        header('Access-Control-Allow-Methods: DELETE');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        if ($stmt->execute()) {
            return array('message' => 'Book Deleted');
        } else {
            return array('message' => 'Book Not Updated');
            printf("Error: %s.\n", $stmt->error);
        }
    }

    

    // public function delete($id)
    // {
    //     $result = $this->db->delete('books', ['id' => $id]);

    //     return $result;
    // }

    // /**
    //  * @param BookOrder $order
    //  *
    //  * @return mixed
    //  */
    // public function sendOrder(BookOrder $order)
    // {
    //     $details = $this->getBook($order->getId());

    //     $message = $this->mailer->buildMessage($order, $details);

    //     return $this->mailer->sendOrderToAdmin($message);
    // }
}
