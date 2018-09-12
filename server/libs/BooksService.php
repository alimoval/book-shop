<?php

class BooksService
{
    private $db;
    private $queryFilters;
    private $mailer;
    private $table = 'books';
    private $name;
    private $description;
    private $price;
    private $authors = [];
    private $genres = [];

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
        $this->data = json_decode(file_get_contents("php://input"));
        $this->name = $this->data->name;
        $this->description = $this->data->description;
        $this->price = $this->data->price;
        $this->authors = $this->data->authors;
        $this->genres = $this->data->genres;
        $query = 'INSERT INTO ' . $this->table . '
                SET name = :name,
                description = :description,
                price = :price';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':name', htmlspecialchars(strip_tags($this->name)));
        $stmt->bindParam(':description', htmlspecialchars(strip_tags($this->description)));
        $stmt->bindParam(':price', htmlspecialchars(strip_tags($this->price)));
        if ($stmt->execute()) {
            $this->bookId = $this->connection->lastInsertId();
            $this->insertRelations();
            return array('message' => 'Book ' . $this->bookId . ' Created');
        } else {
            return array('message' => 'Book Not Created');
            printf("Error: %s.\n", $stmt->error);
        }
    }

    public function update($id)
    {
        header('Access-Control-Allow-Methods: PUT');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        $this->data = json_decode(file_get_contents("php://input"));
        $this->name = $this->data->name;
        $this->description = $this->data->description;
        $this->price = $this->data->price;
        $this->authors = $this->data->authors;
        $this->genres = $this->data->genres;
        $query = 'UPDATE ' . $this->table . '
                SET name = :name,
                description = :description,
                price = :price
                WHERE id = :id';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':name', htmlspecialchars(strip_tags($this->name)));
        $stmt->bindParam(':description', htmlspecialchars(strip_tags($this->description)));
        $stmt->bindParam(':price', htmlspecialchars(strip_tags($this->price)));
        $stmt->bindParam(':id', htmlspecialchars(strip_tags($id)));
        $this->bookId = $id;
        if ($stmt->execute()) {
            $this->insertRelations();
            return array('message' => 'Book ' . $this->bookId . ' Updated');
        } else {
            return array('message' => 'Book ' . $this->bookId . ' Not Updated');
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
            return array('message' => 'Book Deleted');
        } else {
            return array('message' => 'Book Not Updated');
            printf("Error: %s.\n", $stmt->error);
        }
    }

    public function insertRelations()
    {
        // handle authors
        if (!empty($this->authors)) {
            $this->deleteBookAuthorRelation($this->bookId);
            foreach ($this->authors as $authorId) {
                $this->insertBookAuthorRelation($authorId);
            }
        }
        // handle genres
        if (!empty($this->genres)) {
            $this->deleteBookGenreRelation($this->bookId);
            foreach ($this->genres as $genreId) {
                $this->insertBookGenreRelation($genreId);
            }
        }
    }

    public function deleteBookAuthorRelation($id)
    {
        header('Access-Control-Allow-Methods: DELETE');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        $query = 'DELETE FROM book_author_relation WHERE book_id = ?';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        if ($stmt->execute()) {
            return array('message' => 'Book Author Relation Deleted');
        } else {
            return array('message' => 'Book Author Relation Not Deleted');
            printf("Error: %s.\n", $stmt->error);
        }
    }

    public function deleteBookGenreRelation($id)
    {
        header('Access-Control-Allow-Methods: DELETE');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        $query = 'DELETE FROM book_genre_relation WHERE book_id = ?';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $id);
        if ($stmt->execute()) {
            return array('message' => 'Book Genre Relation Deleted');
        } else {
            return array('message' => 'Book Genre Relation Not Deleted');
            printf("Error: %s.\n", $stmt->error);
        }
    }

    public function insertBookAuthorRelation($authorId)
    {
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        $query = 'INSERT INTO book_author_relation
                SET book_id = :bookId,
                author_id = :authorId';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':bookId', htmlspecialchars(strip_tags($this->bookId)));
        $stmt->bindParam(':authorId', htmlspecialchars(strip_tags($authorId)));
        if ($stmt->execute()) {
            return array('message' => 'Book - Author Relation Created');
        } else {
            return array('message' => 'Book - Author Relation Not Created');
            printf("Error: %s.\n", $stmt->error);
        }
    }

    public function insertBookGenreRelation($genreId)
    {
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        $query = 'INSERT INTO book_genre_relation
                SET book_id = :bookId,
                genre_id = :genreId';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':bookId', htmlspecialchars(strip_tags($this->bookId)));
        $stmt->bindParam(':genreId', htmlspecialchars(strip_tags($genreId)));
        if ($stmt->execute()) {
            return array('message' => 'Book - Genre Relation Created');
        } else {
            return array('message' => 'Book - Genre Relation Not Created');
            printf("Error: %s.\n", $stmt->error);
        }
    }    

    public function getAllFiltered($arg)
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
        if ($_GET['authors']) {
            $inClause = str_repeat('?,', count($_GET['authors']) - 1) . '?';
            $whereClause[] = "book_author_relation.author_id IN($inClause)";
            $params = $_GET['authors'];
        }
        if ($_GET['genres']) {
            $inClause = str_repeat('?,', count($_GET['genres']) - 1) . '?';
            $whereClause[] = "book_genre_relation.genre_id IN($inClause)";
            $params = array_merge($params, $_GET['genres']);
        }
        if ($whereClause) {
            $query .= " WHERE " . implode('AND ', $whereClause);
        }
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
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

    // public function sendOrder(BookOrder $order)
    // {
    //     $details = $this->getBook($order->getId());

    //     $message = $this->mailer->buildMessage($order, $details);

    //     return $this->mailer->sendOrderToAdmin($message);
    // }
}
