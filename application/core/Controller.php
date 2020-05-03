<?php

namespace core;

class Controller
{
    /** @var View $view Представление */
    private $view;

    /** @var string $id Идентификатор контроллера */
    public $id;

    /** @var string $action Действие которое будет вызвано */
    public $action;

    
    public function __construct($config)
    {
        $this->id = $config['id'];
        $this->view = new View();
    }


    /**
     * Возвращает представление.
     * @return View
     */
    public function getView() : View
    {
        return $this->view;
    }


    /**
     * Рендерит представление.
     * @param $view Представление.
     * @param mixed $data Данные для рендеринга.
     * @return string
     */
    public function render(string $view, $data) : string
    {
        return $this->getView()->render($view, $data, $this);
    }


    /**
     * Возвращает идентификатор действия.
     */
    public function getActionId()
    {
        $actionId = str_replace('action', '', $this->action);
        return lcfirst($actionId);
    }

    
    public function runAction(string $action) : void
    {
        if (method_exists($this, $action)) {
            $this->action = $action;
            Base::$app->response->response($this->$action(), $this);
        } else {
            Base::$app->route->redirect(Base::$app->route->errorAction);
        }
    }
}
