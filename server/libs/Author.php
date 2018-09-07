<?php

class Author extends AbstractModel implements \JsonSerializable
{
    private $id;
    private $name;

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
    
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public static function fromRequest(Request $request)
    {
        $model = new self();
        $params = $request->getBodyParams();
        $model->name = $params['name'];

        return $model;
    }

    public static function fromArray(array $data)
    {
        $model = new self();
        $model->id   = $data['id'];
        $model->name = $data['name'];

        return $model;
    }

    public function addRelations(array $data)
    {
        return;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
