<?php

namespace core;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    /** @var Illuminate\Database\Capsule\Manager $capsule */
    public $capsule;

    public function __construct($config)
    {
        $capsule = new Capsule;
        $capsule->addConnection(
            array_merge($this->getDefaultConfig(), $config)
        );

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        $this->capsule = $capsule;
    }


    /**
     * Стандартный конфиг БД.
     * @return array
     */
    public function getDefaultConfig() : array
    {
        return [
            "driver" => 'mysql',
            "host" => 'localhost',
            "database" => "database",
            "username" => "root",
            "password" => "",
            "charset" => "utf8",
            "collation" => "utf8_unicode_ci",
            "prefix" => "",
        ];
    }
}
