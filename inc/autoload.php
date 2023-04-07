<?php

function load_classes($class){

$file = 'classes/' . $class . '.php';

if(file_exists($file)) {
    require_once $file;
}

}

spl_autoload_register('load_classes');