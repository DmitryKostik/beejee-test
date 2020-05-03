<?php

namespace core;

class EloquentSort
{
    /** @var array $attributes Аттрибуты доступные для сортировки */
    public $attributes;

    /** @var string $sort Аттрибут по которому будет осуществлятся сортировка */
    public $sortAttribute;


    public function __construct($config)
    {
        $this->attributes = $config['attributes'] ?? [];
    }


    /**
     * Сортирует модели по заданным параметрам.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function sort($query)
    {
        $param = $_GET['sort'] ?? null;
        $descending = false;

        if (strncmp($param, '-', 1) === 0) {
            $descending = true;
            $param = substr($param, 1);
        }

        $this->sort = $param ?? $this->sortAttribute ?? false;
        return in_array($this->sort, $this->attributes)
            ? $query->orderBy($this->sort, $descending ? "DESC" : "ASC")->orderBy('id', $descending ? "ASC" : "DESC")
            : $query;
    }
}
