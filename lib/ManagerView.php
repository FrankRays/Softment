<?php
include_once '../lib/Connection.php';
include_once '../lib/User.php';

class ManagerView{
    public static function navigation(){
        $projects = ManagerView::get_current_projects();
        echo "<nav><ul>";
        foreach($projects as $project) echo "<li><a href='../manager/manager.php?action=task&id=$project[0]'>" . $project[1] . "</a></li>";
        echo "<li style='float: right;'><a href=\"../account/action.php?op=logout\">Salir</a></li>";

        if($_GET){
            // Falta control de acceso de un jefe a otros proyectos modificando la url
            echo "</ul></nav>";
            $id = $_GET['id'];
            echo <<<NAV2
            <nav>
                <ul>
                    <li><a href="../manager/manager.php?action=task&id={$id}">Tareas</a></li>
                    <li><a href="../manager/manager.php?action=team&id={$id}">Equipos de desarrollo</a></li>
                    <li><a href="../manager/manager.php?action=notify&id={$id}">Notificaciones</a></li>
                </ul>
            </nav>
NAV2;
        }
        echo "</ul></nav>";
    }

    private static function get_current_projects(){
        $db = new DB();
        $result = $db->execute_query("SELECT id, name FROM project WHERE manager_id=? AND state=?",
            array(User::getLoggedUser()['id'], "En proceso"));
        $names = $result->fetchAll();
        return $names;
    }

    public static function show_create_task(){
        if(!$_GET) return;
        $task_id = $_GET['id'];
        echo <<<FORM
        <div class="form-container">
            <form action="technical.php?action=project" method="post">
                <div class="form-section">
                    <legend>Nueva Tarea</legend>
                    <p>Nombre del proyecto</p>
                    <input type="text" name="taskName" autofocus>
                    
                    <p>Descripción de la tarea</p>
                    <textarea name="taskDescription"></textarea>
                    
                    <p>Fecha de comienzo</p>
                    <input type="date" name="taskStart">
                    
                    <p>Fecha límite</p>
                    <input type="date" name="taskFinish">
                    
                    <p><a href="../manager/manager.php?action=task&id=$task_id" class="button">Crear tarea.</a></p>
                </div>
            </form>
        </div>
        <div class=clearfix></div>
FORM;
    }

    public static function show_tasks_with($state){
        if(!$_GET) return;

        echo "<h1>Tareas $state</h1>";
        $db = new DB();
        $result = $db->execute_query("SELECT * FROM task WHERE project_id=? AND state=?;", array($_GET['id'], $state));

        if($result){
            $result->setFetchMode(PDO::FETCH_NAMED);
            $first = true;

            foreach($result as $task){
                if($first){
                    echo <<<HEAD
                    <table class='horizontalTable tasks'>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Fecha Inicial</th>
                            <th>Fecha Límite</th>
                            <th>Equipo</th>
                            <th>Acciones</th>
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
                    <td>---</td>
                    <td><button class=button>Editar</button> - <button class=button>Eliminar</button></td>
                </tr>
BODY;
            }
            echo "</table><hr>";
        }
    }

    public static function show_teams(){
        if(!$_GET) return;

        echo "<h1>Equipos disponibles</h1>";
        $db = new DB();
        $result = $db->execute_query("SELECT * FROM team WHERE project_id=?;",
            array($_GET['id']));

        if($result){
            $result->setFetchMode(PDO::FETCH_NAMED);
            $first = true;

            foreach($result as $team){
                if($first){
                    echo <<<HEAD
                    <table class="horizontalTable projects">
                        <tr>
                            <th>Nombre</th>
                            <th>Miembros</th>
                        </tr>
HEAD;
                    $first = false;
                }
                $teamMembers = self::get_team_members_from_team($team['id']);
                echo <<<BODY
                <tr>
                    <td>{$team['name']}</td>
                    <td>{$teamMembers}</td>
                </tr>
BODY;
            }
            echo "</table><hr>";
        }
    }

    public static function show_notify(){
        if(!$_GET) return;

        echo "<h1>Notificaciones</h1>";
        $db = new DB();
        $result = $db->execute_query("SELECT * FROM notification WHERE project_id=? AND state=?;",
            array($_GET['id'], "Pendiente"));

        if($result){
            $result->setFetchMode(PDO::FETCH_NAMED);
            $first = true;

            foreach($result as $notify){
                if($first){
                    echo <<<HEAD
                    <table class='horizontalTable tasks'>
                        <tr>
                            <th>Usuario</th>
                            <th>Proyecto</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
HEAD;
                    $first = false;
                }
                echo <<<BODY
                <tr>
                    <td>{$notify['user_id']}</td>
                    <td>{$notify['project_id']}</td>
                    <td>{$notify['name']}</td>
                    <td>{$notify['description']}</td>
                    <td><button class=button>Resolver</button></td>
                </tr>
BODY;
            }
            echo "</table>";
        }
    }

    private static function get_team_members_from_team($id){
        if($id == "") return "---";

        $db = new DB();
        $result = $db->execute_query("SELECT name FROM (resource INNER JOIN team_member ON resource.id=team_member.resource_id) WHERE team_id=?;",
            array($id));
        $result = $result->fetchAll();

        $names = "";
        foreach($result as $name) $names .= $name['name'] . "<br>";
        return $names;
    }
}
?>