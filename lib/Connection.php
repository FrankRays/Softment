<?php
class DB{
    private static $connection=null;

    public function __construct(){
        $this->connect();
    }

    private function connect(){
        if(self::$connection === null) {
            self::$connection = new PDO("sqlite:../db.db");
            self::$connection->exec("PRAGMA foreign_keys = ON;");
            self::$connection->exec("PRAGMA encoding='UTF-8';");
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public function execute_query($query, $parameters = null){
        try{
            $result = self::$connection->prepare($query);
            $result->execute($parameters);
            return $result;
        }catch (PDOException $e){
            echo '<h1>Error en la base de datos: ' . $e->getMessage() . '</h1>';
        }
        return "";
    }

    public function disconnect(){
        if(self::$connection !== null){
            self::$connection = null;
        }
    }
}
?>