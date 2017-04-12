<?php
include_once '../lib/Connection.php';

class TeamView{
    public static function navigation(){
        echo <<<NAV
        <nav>
            <ul>
                <li><a>Tareas</a></li>
                <li><a>Notificaciones</a></li>
            </ul>
        </nav>
NAV;
    }
    // FALTA IMPLEMENTACION
    public static function show_tasks(){

    }
}

?>