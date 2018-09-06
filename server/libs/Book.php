<?php

class Book extends AbstractModel implements \JsonSerializable
{
    private $id;
    private $name;
    private $description;
    private $price;
    private $genres = [];
    private $authors = [];

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getGenres(): array
    {
        return $this->genres;
    }

    public function getAuthors(): array
    {
        return $this->authors;
    }

    public function addGenre($genre)
    {
        if (!in_array($genre, $this->genres)) {
            $this->genres[] = $genre;
        }

        return $this;
    }

    public function addAuthor($author)
    {
        if (!in_array($author, $this->authors)) {
            $this->authors[] = $author;
        }

        return $this;
    }

    public static function fromRequest(Request $request)
    {
        $model = new self();

        $params             = $request->getBodyParams();
        $model->name        = $params['name'];
        $model->description = $params['description'];
        $model->price       = $params['price'];
        if (isset($params['authors'])) {
            foreach ($params['authors'] as $authorId) {
                $model->addAuthor($authorId);
            }
        }
        if (isset($params['genres'])) {
            foreach ($params['genres'] as $genreId) {
                $model->addGenre($genreId);
            }
        }

        return $model;
    }

    public static function fromArray(array $data)
    {
        $model = new self();

        $model->id          = $data['id'];
        $model->name        = $data['name'];
        $model->description = $data['description'];
        $model->price       = $data['price'];

        if (!empty($data['genre'])) {
            $model->addGenre($data['genre']);
        }

        if (!empty($data['author'])) {
            $model->addAuthor($data['author']);
        }

        return $model;
    }

    public function addRelations(array $data)
    {
        if (!empty($data['genre'])) {
            $this->addGenre($data['genre']);
        }

        if (!empty($data['author'])) {
            $this->addAuthor($data['author']);
        }
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
