<?php

namespace controllers;

use core\Base;
use core\Controller;
use core\EloquentDataProvider;
use models\Task;

class MainController extends Controller
{
    public function actionIndex()
    {
        $provider = new EloquentDataProvider([
            'query' => Task::select("*"),
            'sort' => [
                'attributes' => ['username', 'email', 'is_active']
            ],
            'pagination' => [
                'perPage' => 3,
            ]
        ]);

        return ['tasks' => $provider->getModels(), 'pagination' => $provider->getPagination()];
    }


    public function actionSwitch()
    {
        if (Base::$app->user->getIsGuest()) {
            return false;
        }

        $task = Task::findById(Base::$app->request->post('id'));

        if (!$task) {
            return false;
        }

        $completed = Base::$app->request->post('checked');
        $completed = intval($completed);
        $task->is_active = $completed ? 1 : 0;
        return $task->save();
    }


    public function actionAdd()
    {
        $request = Base::$app->request;

        if (!$request->isPost()) {
            return;
        }

        return Task::add(
            $request->post('username'),
            $request->post('email'),
            $request->post('task'),
        );
    }


    public function actionChange()
    {
        if (Base::$app->user->getIsGuest()) {
            return ['error_msg' => 'Необходима авторизация'];
        }

        $task = Task::findById(Base::$app->request->post('id'));

        if (!$task) {
            return ['error_msg' => 'Задача не найдена'];
        }

        $text = Base::$app->request->post('task');
        if (empty($text)) {
            return ['error_msg' => 'Задача не может быть пустой'];
        }

        $task->task = $text;
        return $task->save();
    }


    public function action404()
    {
        return true;
    }
}
