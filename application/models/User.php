<?php

namespace models;

use core\Base;

class User extends BaseModel
{
    /** @var bool Включены ли поля updated_at, created_at */
    public $timestamps = false;

    /** @var string Название таблицы */
    protected $table = 'user';
    

    /**
     * Находит пользователя по логину.
     * @param string $email Email.
     * @return User|null
     */
    public static function findByUsername($username)
    {
        return static::where('username', $username)->first();
    }


    /**
     * Находит пользователя по id.
     * @param int $id Id.
     * @return User|null
     */
    public static function findById($id)
    {
        return static::where('id', $id)->first();
    }
    
    
    /**
     * Находит пользователя по логину и паролю.
     * @param string $username Имя пользователя.
     * @param string $password Пароль.
     * @return User|null
     */
    public static function findByCredentials($username, $password)
    {
        if (!$user = static::findByUsername($username)) {
            return null;
        }

        if (!$user->validatePasswordHash($password)) {
            return null;
        }

        return $user;
    }


    /**
     * Проверяет сопадает ли пароль с его хешем.
     * @param string $password
     */
    public function validatePasswordHash($password) : bool
    {
        return Base::$app->security->validatePassword($password, $this->password_hash);
    }
}
