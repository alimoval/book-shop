<?php

class Collection implements \JsonSerializable
{

    private $data = [];

    public function getItems(): array
    {
        return $this->data;
    }

    public function hasItem($index)
    {
        return isset($this->data[$index]);
    }

    public function getItem($index)
    {
        return $this->data[$index];
    }

    public function setItem($index, $item)
    {
        $this->data[$index] = $item;

        return $this;
    }

    public static function fromRawData(array $data, $model)
    {
        $collection = new self();
        foreach ($data['data'] as $entry) {
            $id = (int) $entry['id'];
            if (!$collection->hasItem($id)) {
                $item = $model::fromArray($entry);
                $collection->setItem($id, $item);
            } else {
                $item = $collection->getItem($id);
                $item->addRelations($entry);
                $collection->setItem($id, $item);
            }
        }

        return $collection;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
