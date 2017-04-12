<?php
include_once '../lib/Connection.php';

class User{
    public static function session_start(){
        if(session_status () === PHP_SESSION_NONE){
            session_start();
        }
    }

    public static function getLoggedUser(){ //Devuelve un array con los datos del cuenta o false
        self::session_start();
        if(!isset($_SESSION['user'])) return false;
        return $_SESSION['user'];
    }

    public static function login($user, $password)
    {
        self::session_start();

        $db = new DB();
        $instance = $db->execute_query("SELECT * FROM user WHERE nickname=? and password=?", array($user, $password));
        $instance->setFetchMode(PDO::FETCH_NAMED);

        $res = $instance->fetchAll();
        if (count($res) == 1) {
            $_SESSION['user'] = $res[0];
            return true;
        }
        return false;
    }

    public static function logout(){
        self::session_start();
        unset($_SESSION['user']);
    }
}
?>