<?php

namespace core;

class Security
{
    /** @var int $passwordHashCost Алгоритмическая стоимость хеша */
    public $passwordHashCost = 15;


    public function __construct($config)
    {
        $this->passwordHashCost = $config['passwordHashCost'] ?? $this->passwordHashCost;
    }


    /**
     * Генерирует хеш пароля.
     * @param string $password Пароль.
     * @param int|null $cost Алгоритмическая стоимость хеша, если не указано будет
     * использовано случайное значение
     * @return string
     */
    public function generatePasswordHash($password, $cost = null)
    {
        if ($cost === null) {
            $cost = $this->passwordHashCost;
        }

        return password_hash($password, PASSWORD_DEFAULT, ['cost' => $cost ?? $this->passwordHashCost]);
    }


    /**
     * Сверяет хеш с паролем.
     * @param string $password Пароль.
     * @param string $hash Хеш.
     * @return bool
     */
    public function validatePassword($password, $hash) : bool
    {
        if (!is_string($password) || $password === '') {
            return false;
        }

        if (!preg_match('/^\$2[axy]\$(\d\d)\$[\.\/0-9A-Za-z]{22}/', $hash, $matches)
            || $matches[1] < 4
            || $matches[1] > 30
        ) {
            return false;
        }

        return password_verify($password, $hash);
    }
}
