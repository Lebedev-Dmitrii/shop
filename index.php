<?php

// FRONT CONTROLLER

//общие настройки
ini_set('display_errors',1);
error_reporting(E_ALL);

//начинаем сессию
session_start();

//подключение файлов системы
define('ROOT', dirname(__FILE__));
require_once(ROOT.'/models/Autoload.php');


//вызов Router
$router = new Router();
$router->run();



