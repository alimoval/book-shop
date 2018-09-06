<?php

class Collection implements \JsonSerializable
{

    private $items = [];

    public function getItems(): array
    {
        return $this->items;
    }

    public function hasItem($index)
    {
        return isset($this->items[$index]);
    }

    public function getItem($index)
    {
        return $this->items[$index];
    }

    public function setItem($index, $item)
    {
        $this->items[$index] = $item;

        return $this;
    }

    public static function fromRawData(array $data, $model)
    {
        $collection = new self();

        foreach ($data as $entry) {
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
