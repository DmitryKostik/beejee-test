<?php

namespace core;

class EloquentPagination
{
    /** @var int $perPage Количество моделей на странице */
    public $perPage = 10;

    /** @var int $currentPage Текущая страница */
    public $currentPage;

    /** @var int $totalCount Количество моделей */
    public $totalCount;

    /** @var int $totalPages Количество страниц */
    public $totalPages;

    /** @var int $offset Смещение */
    public $offset;

    /** @var int|null $nextPage Следующая страница, или `null` если она отсутствует */
    public $nextPage;

    /** @var int|null $nextPage Предыдущая страница, или `null` если она отсутствует */
    public $previousPage;

    /** @var array $links Массив ссылок */
    public $links = [];


    public function __construct($config)
    {
        $this->perPage = intval($config['perPage']) ?? $this->perPage;
    }


    /**
     * Устанавливает limit && offset
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function setPagination($query)
    {
        return $query->offset($this->getOffset($query))->limit($this->perPage);
    }


    /**
     * Определяет offset
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return int
     */
    public function getOffset($query)
    {
        return $this->offset = ($this->detectPage($query) - 1) * $this->perPage;
    }


    /**
     * Устанвливает предыдущую и следующую страницу если она существует.
     * @param $page Текущая страница.
     * @return void
     */
    public function setPreviousNext(int $page) : void
    {
        if ($this->totalPages == 1) {
            return;
        }

        

        
        if ($page != 1) {
            $this->previousPage = $page - 1;
            
            $this->links['previous'] = [
                'number' => "<",
                'link' => $this->getLinkByPage($this->previousPage)
            ];
            
            $this->links['first'] = [
                'number' => 1,
                'link' => $this->getLinkByPage(1)
            ];
        }
        
        if ($page - 2 > 1) {
            $this->links['page2Left'] = [
                'number' => $page - 2,
                'link' => $this->getLinkByPage($page - 2)
            ];
        }
        
        if ($page - 1 > 1) {
            $this->links['page1Left'] = [
                'number' => $page - 1,
                'link' => $this->getLinkByPage($page - 1)
            ];
        }

        $this->links['current'] = [
            'number' => $page,
            'link' => ''
        ];
        
        if ($page + 1 < $this->totalPages) {
            $this->links['page2Right'] = [
                'number' => $page + 1,
                'link' => $this->getLinkByPage($page + 1)
            ];
        }

        if ($page + 2 < $this->totalPages) {
            $this->links['page2Right'] = [
                'number' => $page + 2,
                'link' => $this->getLinkByPage($page + 2)
            ];
        }
        

        if ($page != $this->totalPages) {
            $this->links['last'] = [
                'number' => $this->totalPages,
                'link' => $this->getLinkByPage($this->totalPages)
            ];

            $this->nextPage = $page + 1;
            $this->links['next'] = [
                'number' => ">",
                'link' => $this->getLinkByPage($this->nextPage)
            ];
    
        }
        
        return;
    }
    

    /**
     * Определяет страницу.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return int Текущая страница.
     */
    public function detectPage($query)
    {
        $page = Base::$app->request->get('page', 1);
        $page = intval($page);
        $page = $page ?: 1;
        
        if ($page > $this->getTotalPages($query)) {
            $page = $this->getTotalPages($query);
        }
        $this->setPreviousNext($page);
        return $this->currentPage = $page;
    }


    /**
     * Получает общее количество страниц.
     * @param \Illuminate\Database\Eloquent\Builder
     * @return int
     */
    public function getTotalPages($query)
    {
        return $this->totalPages = intval(($this->getTotalCount($query) - 1) / $this->perPage) + 1;
    }

    /**
     * Получает общее количество моделей.
     * @param \Illuminate\Database\Eloquent\Builder
     * @return int
     */
    public function getTotalCount($query)
    {
        return $this->totalCount ?? $this->totalCount = $query->count();
    }


    /**
     * Формирует query string для пагинации.
     * @param int $page
     * @return string
     */
    public function getLinkByPage(int $page) : string
    {
        return Base::$app->route->buildQueryString(array_merge($_GET, ["page" => $page]));
    }
}
