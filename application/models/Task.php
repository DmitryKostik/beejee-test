<?php

namespace models;

class Task extends BaseModel
{
    public const TASK_ACTIVE = 1;
    public const TASK_INACTIVE = 0;

    public const TASK_EDIT = 1;
    public const TASK_ORGINAL = 0;
    
    /** @var bool Включены ли поля updated_at, created_at */
    public $timestamps = false;

    /** @var string Название таблицы */
    protected $table = 'task';

    /** @var string[] Атрибуты которые могут быть массово присвоены */
    protected $fillable = ['username', 'email', 'task'];

    /** @var array Стандартные значения */
    protected $attributes = [
        'is_active' => 0,
        'is_edited' => 0
    ];


    /**
     * Находит задачу по id.
     * @param int $id Id.
     * @return Task|null
     */
    public static function findById($id)
    {
        return static::where('id', $id)->first();
    }


    /**
     * Добавляет новую задачу.
     * @param string $username Имя пользователя.
     * @param string $email email.
     * @param string $task Задача.
     * @return bool|array
     */
    public static function add($username, $email, $task)
    {
        $model = new static;

        $model->username = $username = trim($username);
        $model->email = $email = trim($email);
        $model->task = $task = trim($task);

        if (!$model->validate($username, $email, $task)) {
            return ['errors' => $model->errors, 'model' => $model];
        }
        
        return $model->save();
    }


    /**
     * Проверяет модель на корректность.
     * @param string $username Имя пользователя.
     * @param string $email email.
     * @param string $task Задача.
     */
    public function validate($username, $email, $task) : bool
    {
        $this->validateEmailCorrect($email);
        $this->validateEmpty('Имя пользователя', $username);
        $this->validateEmpty('Задача', $task);

        return empty($this->errors);
    }


    /**
     * Проверяет email
     * @param string $email
     */
    public function validateEmailCorrect($email) : bool
    {
        if (!$this->validateEmpty('email', $email)) {
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError('email', 'Неккоректный email');
            return false;
        }

        return true;
    }


    /**
     * @inheritdoc
     */
    public function save(array $options = [])
    {
        /** Обработка изменения текста администратором */
        if ($this->exists === true && $this->task != $this->getOriginal('task')) {
            $this->is_edited = self::TASK_EDIT;
        }

        return parent::save($options);
    }
}
