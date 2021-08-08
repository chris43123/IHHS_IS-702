<?php

class Utils{
    public static function deleteSession($name){
        if(isset($_SESSION[$name])){
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
        
        return $name;
    }
}

class Validate{
    public static function validateData($campo){
        if(isset($campo)){
            $campoValidado = $campo;
        } else {
            $campoValidado = false;
        }
        
        return $campoValidado;
    }
}

?>