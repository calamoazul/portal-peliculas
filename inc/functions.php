<?php


function get_template(string $name_template):void {

    $file = 'templates/' . $name_template . '.php';
    if(file_exists($file)) {
        require_once $file;
    }
}
