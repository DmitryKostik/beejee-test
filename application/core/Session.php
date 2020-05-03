<?php

namespace core;

class Session
{

    public function init()
    {
        register_shutdown_function([$this, 'close']);
        $this->open();
    }


    /**
     * Запускает сессию.
     */
    public function open()
    {
        if ($this->getIsActive()) {
            return;
        }

        @session_start();
    }


    /**
     * Закрывает текущую сессию.
     */
    public function close()
    {
        if ($this->getIsActive()) {
            @session_write_close();
        }
    }

    /**
     * Удаляет текущую сессию.
     */
    public function destroy()
    {
        if ($this->getIsActive()) {
            $sessionId = session_id();
            $this->close();
            $this->setId($sessionId);
            $this->open();
            session_unset();
            session_destroy();
            $this->setId($sessionId);
        }
    }

    /**
     * @return bool Запущена ли сессия.
     */
    public function getIsActive()
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }


    /**
     * Устанавливает значение существования сессии.
     * @param bool Существует ли сессия
     * @return void
     */
    public function setHasSessionId(bool $value) : void
    {
        $this->_hasSessionId = $value;
    }


    /**
     * Возвращает идентификатор сессии.
     * @return string
     */
    public function getId() : string
    {
        return session_id();
    }


    /**
     * Устанавливает идентификатор сессии.
     * @param string $id Идентификатор.
     * @return void
     */
    public function setId($id) : void
    {
        session_id($id);
    }
}