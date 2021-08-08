<?php

//Funcion para autocargar los controladores
function controller_autoload($classname) {
    include 'controllers/' . $classname . '.php';
}

spl_autoload_register('controller_autoload');

?>