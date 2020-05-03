<?php

namespace core;

use models\User as ModelsUser;

class User
{
    /** @var models\User $identity Пользователь */
    public $identity;


    public function init()
    {
        $this->loginBySession();
    }


    /**
     * Пытается авторизовать пользователя по сессии.
     * @return bool
     */
    public function loginBySession() : bool
    {
        $userId = Base::$app->session->readCurrentSession();

        if (!$userId) {
            return false;
        }
        
        $this->switchIdentity(ModelsUser::findById($userId));
        return true;
    }


    /**
     * Авторизовывает пользователя.
     * @param models\User Модель пользователя.
     */
    public function login($identity) : void
    {
        Base::$app->session->writeCurrentSession($identity->id);
        $this->switchIdentity($identity);
    }


    /**
     * Выход пользователя.
     * Удаляет сессию пользователя.
     */
    public function logout()
    {
        $this->switchIdentity(null);
        Base::$app->session->destroy();
    }


    /**
     * Меняет модель пользователя.
     * @param models\User|null
     */
    public function switchIdentity($identity) : void
    {
        $this->identity = $identity;
    }


    /**
     * @return bool Является ли текущий пользователь гостем.
     */
    public function getIsGuest() : bool
    {
        return !isset($this->identity);
    }
}
