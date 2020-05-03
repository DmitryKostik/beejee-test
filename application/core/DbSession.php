<?php

namespace core;

use Illuminate\Database\Capsule\Manager as DB;

class DbSession extends Session
{
    /** @var string $tableName Название таблицы сессии */
    public $tableName = 'session';

    /** @var int $lifetime Время жизни сессии */
    public $lifetime = 60*60*24;

    /** @var int|null $userId Идентификатор пользователя, или `null` если не авторизован */
    private $userId = null;


    public function __construct($config)
    {
        $this->lifetime = $config['lifetime'] ?? $this->lifetime;
        $this->tableName = $config['tableName'] ?? $this->tableName;
        $this->init();
    }


    /**
     * Инициирует старт сессии, получает значения из БД,
     * или записывает если сессия новая.
     */
    public function init()
    {
        parent::init();
        if (!$this->readCurrentSession()) {
            $this->writeCurrentSession($this->userId);
        }
    }


    /**
     * Читает текущую сессию.
     * Возваращет идентификатор пользователя.
     * @return int|false Идентфикатор пользователя, или `false` если пользователь не авторизован.
     */
    public function readCurrentSession()
    {
        return $this->readSession($this->getId());
    }


    /**
     * Записывает данные в текущую сессию.
     * @param int|null $userId Идентификатор пользователя.
     * @return int Количество обновленных строк.
     */
    public function writeCurrentSession($userId)
    {
        return $this->writeSession($this->getId(), $userId);
    }


    /**
     * Сеттер для идентификтора пользователя.
     * @param int|null $userId Идентификатор пользователя.
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }


    /**
     * Геттер для идентификатор пользователя.
     * @return int|null
     */
    public function getUserId()
    {
        return $this->userId;
    }


    /**
     * Читает сессию по идентификатору.
     * Возвращает false если сессия не найдена, или истек срок ее жизни.
     * @param string $id Идентификатор сессии.
     * @return int|false Идентификатор пользователя.
     */
    public function readSession($id)
    {
        $userId = DB::table($this->tableName)
        ->where([
            ['id', '=', $id],
            ['expire', '>', time()],
        ])->value('user_id');

        if (!$userId) {
            return false;
        }

        return $this->userId = $userId;
    }


    /**
     * Записывает данные в сессию по идентификатору.
     * @param string $id Идентификатор сессии.
     * @param int|null $userId Идентификатор пользователя.
     * @return int Количество обновленных записей.
     */
    public function writeSession($id, $userId)
    {
        $this->userId = $userId;

        $isInsert = DB::table($this->tableName)->where('id', $id)->doesntExist();

        if ($isInsert) {
            return DB::table($this->tableName)->insert([
                ['id' => $id, 'user_id' => $userId, 'expire' => time() + $this->lifetime],
            ]);
        }
        
        
        return DB::table($this->tableName)
            ->where('id', $id)
            ->update(
                ['user_id' => $userId]
            );
    }


    /**
     * Удаляет текущую сессию из БД.
     * @return void
     */
    public function destroy() : void
    {
        if (!$this->getIsActive()) {
            return;
        }

        $id = $this->getId();
        $this->destroySession($id);
        parent::destroy();
    }


    /**
     * Удаляет сессию из БД по идентификатору.
     * @param string $id Идентификатор сессии.
     * @return bool Успешное удаление, или нет.
     */
    public function destroySession($id)
    {
        $rows = DB::table($this->tableName)->where('id', $id)->delete();
        return $rows > 0;
    }
}
