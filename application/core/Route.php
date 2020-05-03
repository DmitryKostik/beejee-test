<?php

namespace core;

class Route
{
    private $defaultController = 'main';
    private $defaultAction = 'index';

    public $errorAction = "main/404";

    public $controllerId;
    public $controller;
    public $action;
    public $model;

    const MODEL_POSTFIX = 'Model';
    const CONTROLLER_POSTFIX = 'Controller';
    const ACTION_PREFIX = 'action';

    public function __construct($config)
    {
        $this->defaultController = $config['defaultController'] ?? $this->defaultController;
        $this->defaultAction = $config['defaultAction'] ?? $this->defaultAction;
    }


    /**
     * Определяет маршрут и запускает метод контроллера.
     */
    public function run()
    {
        $this->detectRoute();

        $controllerClassName = "controllers\\$this->controller";

        if (!class_exists($controllerClassName)) {
            $this->setRoute("/" . $this->errorAction);
            $controllerClassName = "controllers\\$this->controller";
        }

        /** @var Controller $controller */
        $controller = new $controllerClassName(['id' => $this->controllerId]);
        return $controller->runAction($this->action);
    }


    /**
     * Определяет контроллер и действие.
     * Если контроллер не запрошен устанавливает стандартное значение.
     * Если метод не запрошен устанавливает стандартное значение.
     * @return void
     */
    public function detectRoute() : void
    {
        $uri = $this->getUriWithoutQueryParams();
        $this->setRoute($uri);
    }


    /**
     * Устанавливает параметры маршрута.
     * @param string $route Маршрут.
     * @return void
     */
    public function setRoute($route) : void
    {
        $parts = explode('/', $route);

        $controller = empty($parts[1]) ? $this->defaultController : $parts[1];
        $controller = strtolower($controller);
        $controller = ucfirst($controller);
        
        $action = empty($parts[2]) ? $this->defaultAction : $parts[2];
        $action = strtolower($action);
        $action = ucfirst($action);
        
        $this->controllerId = $controller;
        $this->controller = $controller . self::CONTROLLER_POSTFIX;
        $this->action = self::ACTION_PREFIX . $action;
        $this->model = $controller . self::MODEL_POSTFIX;
    }


    /**
     * @return string Запрошенный URI без параметров.
     */
    private function getUriWithoutQueryParams()
    {
        return strtok($_SERVER["REQUEST_URI"], '?');
    }


    /**
     * Создает строку запроса из параметров.
     * @param $params Параметры.
     * @return string
     */
    public function buildQueryString($params)
    {
        if (!is_array($params) || empty($params)) {
            return '';
        }

        return "?" . http_build_query($params);
    }


    /**
     * Выполняет перенаправление.
     * Завершает работу приложения.
     * @param $route Маршрут.
     */
    public function redirect($route)
    {
        Base::$app->response->setHeader('Location', "/" . $route);
        exit();
    }
}
