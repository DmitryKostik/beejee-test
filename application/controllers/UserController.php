<?php

namespace controllers;

use core\Base;
use core\Controller;
use models\User;

class UserController extends Controller
{
    public function actionLogin()
    {
        if (!Base::$app->user->getIsGuest()) {
            return Base::$app->route->redirect('');
        }

        if (Base::$app->request->isGet()) {
            return true;
        }

        $request = Base::$app->request;
        $username = $request->post('username');
        $password = $request->post('password');

        if (empty($username) || empty ($password)) {
            return ['errors' => ['Ошибка' => ['Поля не должны быть пусты']]];
        }

        if ($user = User::findByCredentials($username, $password)) {
            Base::$app->user->login($user);
        } else {
            return ['errors' => ['Ошибка' => ['Неверный логин, или пароль']]];
        }

        if (!Base::$app->user->getIsGuest()) {
            return Base::$app->route->redirect('');
        }
    }


    public function actionLogout()
    {
        if (!Base::$app->request->isPost()) {
            return;
        }

        if (!Base::$app->user->getIsGuest()) {
            Base::$app->user->logout();
        }
        
        Base::$app->route->redirect('user/login');
    }
}
