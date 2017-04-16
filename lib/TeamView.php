<?php
include_once '../lib/Connection.php';

class TeamView{

    public static function navigation(){
        echo <<<NAV
        <nav>
            <ul>
                <li><a href="../team/team.php?action=task">Tareas</a></li>
                <li><a href="../team/team.php?action=noti">Notificaciones</a></li>
                <li style="float: right;"><a href="../account/action.php?op=logout">Salir</a></li>
            </ul>
        </nav>
NAV;
    }

    public static function show_tasks_with($state){
        echo "<h1>Tareas $state</h1>";
        $db = new DB();
        $result = $db->execute_query("SELECT * FROM task WHERE team_id=(SELECT id FROM team WHERE user_id=?) AND state=?;",
            array(User::getLoggedUser()['id'], $state));

        if($result){
            $result->setFetchMode(PDO::FETCH_NAMED);
            $first = true;

            foreach($result as $task){
                if($first){
                    echo <<<HEAD
                    <table class="horizontalTable tasks">
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Final</th>
                        </tr>
HEAD;
                    $first = false;
                }
                $startDate = date("Y-m-d H:i:s", $task['start_date']);
                $finishDate = date("Y-m-d H:i:s", $task['finish_date']);
                echo <<<BODY
                <tr>
                    <td>{$task['name']}</td>
                    <td>{$task['description']}</td>
                    <td>{$startDate}</td>
                    <td>{$finishDate}</td>
                </tr>
BODY;
            }
            echo "</table><hr>";
        }
    }

    public static function show_notifications_with($state){
        echo "<h1>Notificaciones $state</h1>";
        $db = new DB();
        $result = $db->execute_query("SELECT * FROM notification WHERE user_id=? AND state=?;",
            array(User::getLoggedUser()['id'], $state));

        if($result){
            $result->setFetchMode(PDO::FETCH_NAMED);
            $first = true;

            foreach($result as $notification){
                if($first){
                    echo <<<HEAD
                    <table class="horizontalTable">
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                        </tr>
HEAD;
                    $first = false;
                }
                echo <<<BODY
                <tr>
                    <td>{$notification['name']}</td>
                    <td>{$notification['description']}</td>
                </tr>
BODY;
            }
            echo "</table><hr>";
        }
    }

    public static function show_create_notification(){
        echo <<<FORM
        <div class="form-container">
            <form action="../team/team.php?action=noti" method="post">
                <div class="form-section">
                    <legend>Nueva notificación</legend>
                    
                    <p>Título</p>
                    <input type="text" autofocus>
                    
                    <p>Descripción</p>
                    <textarea></textarea>
                </div>
                <button class="button">Crear notificación</button>
            </form>
        </div>
FORM;
    }

}

?>