<?php

abstract class AbstractModel
{
    abstract public static function fromArray(array $data);

    abstract public function addRelations(array $data);

    abstract public static function fromRequest(Request $request);
}
