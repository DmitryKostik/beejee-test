<?php

namespace core;

class EloquentDataProvider
{
    /** @var EloquentSort $sort */
    private $sort;

    /** @var EloquentPagination $pagination */
    private $pagination;

    /** @var \Illuminate\Database\Eloquent\Builder */
    public $query;


    public function __construct($config)
    {
        $this->query = $config['query'];
        $this->pagination = new EloquentPagination($config['pagination']);
        $this->sort = new EloquentSort($config['sort']);
    }


    /**
     * Возвращает модели отсорированные модели с пагинацией.
     * @return Illuminate\Database\Eloquent\Model[];
     */
    public function getModels()
    {
        if (empty($this->query)) {
            return [];
        }

        $query = $this->pagination->setPagination($this->query);
        $query = $this->sort->sort($query);
        return $query->get();
    }

    
    /**
     * Возвращает объект сортировки.
     * @return EloquentSort
     */
    public function getSort()
    {
        return $this->sort;
    }


    /**
     * Возвращает объект пагинации.
     * @return EloquentPagination
     */
    public function getPagination()
    {
        return $this->pagination;
    }
}
