<?php

//автозагрузка моделей
function my_autoloader($class) {
    include ROOT.'/models/'.$class.'.php';
}

spl_autoload_register('my_autoloader');

