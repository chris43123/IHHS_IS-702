<?php

//Clase y metodo de conexion a la db
class Database{
    public static function connect(){
        $db = new mysqli(
            'localhost',
            'root',
            '',
            'centromedico'
        );
        //Set parra que las consultas devuelvan caracteres del español
        $db->query("SET NAMES 'utf8'");
        return $db;
    }
}
?>

