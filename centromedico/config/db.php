<?php
//Clase y metodo de conexion a la db
class Database{
    public static function connect(){
        $db = new mysqli(
            '192.241.138.101',
            'sa',
            'PumasUNAH.2021',
            'IHSS_DevOps'
        );
        //Set parra que las consultas devuelvan caracteres del español
        $db->query("SET NAMES 'utf8'");
        return $db;
    }
}
?>

