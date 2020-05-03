<?php

namespace models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public $errors = [];


    /**
     * Проверяет поле на пустоту
     * @param string $name Имя поля
     * @param string $value Значение
     */
    public function validateEmpty($name, $value) : bool
    {
        if (!empty($value)) {
            return true;
        }

        $this->addError($name, 'Поле не должно быть пустым');
        return false;
    }


    /**
     * Добавляет ошибку в модель.
     * @param string $attribute Аттрибут к которому относится ошибка.
     * @param string $msg Сообщение
     */
    public function addError($attribute, $msg) : void
    {
        $this->errors[$attribute][] = $msg;
    }
}
