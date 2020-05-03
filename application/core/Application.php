<?php

namespace core;

class Application
{
    /** @var Route Маршрутиризатор */
    public $route;

    /** @var Request Запрос */
    public $request;

    /** @var Response Ответ */
    public $response;

    /** @var Database База данных */
    public $db;

    /** @var Security Безопасность  */
    public $security;

    /** @var DbSession Сессия */
    public $session;

    /** @var User Пользователь */
    public $user;


    public function __construct($config)
    {
        $this->db = new Database($config['db']);
        $this->session = new DbSession($config['session'] ?? []);
        $this->user = new User();
        $this->route = new Route($config['route'] ?? null);
        $this->security = new Security($config['security'] ?? null);
        $this->request = new Request();
        $this->response = new Response();
        Base::$app = $this;
    }

    public function start()
    {
        $this->response->init();
        $this->user->init();
        $this->route->run();
    }
}
