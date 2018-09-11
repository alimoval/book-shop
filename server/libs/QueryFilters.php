<?php

class QueryFilters
{

    private $genres = [];
    private $authors = [];

    public function getGenres()
    {
        return $this->genres;
    }

    public function getAuthors()
    {
        return $this->authors;
    }

    public static function fromRequest(Request $request)
    {
        $self          = new self();
        $self->genres  = $request->getQueryParams()['genres'] ?? [];
        $self->authors = $request->getQueryParams()['authors'] ?? [];

        return $self;
    }

    public function hasFilter(string $filter)
    {
        return empty($this->$filter) ? false : true;
    }
}
