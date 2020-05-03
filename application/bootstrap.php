<?php

require_once dirname(dirname(__FILE__)) . "/vendor/autoload.php";

/** @var string PROJECT_PATH projectpath */
define("PROJECT_PATH", dirname(dirname(__FILE__)));

$config = require __DIR__ . '/config/main.php';
(new core\Application($config))->start();
