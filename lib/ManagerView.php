<?php
include_once '../lib/Connection.php';
include_once '../lib/User.php';

class ManagerView{
    public static function navigation(){
        $projects = ManagerView::get_projects_name_with(User::getLoggedUser()['id']);
        echo "<nav><ul>";
        foreach($projects as $project) echo "<li><a href='../manager/manager.php?action=task&id=$project[0]'>" . $project[1] . "</a></li>";
        echo "<li style=\"float: right;\"><a href=\"../account/action.php?op=logout\">Salir</a></li>";

        if($_GET){
            // Falta control de acceso de un jefe a otros proyectos modificando la url
            echo "</ul></nav>";
            $id = $_GET['id'];
            echo <<<NAV2
            <nav>
                <ul>
                    <li><a href="../manager/manager.php?action=task&id={$id}">Tareas</a></li>
                    <li><a href="../manager/manager.php?action=team&id={$id}">Equipos de desarrollo</a></li>
                    <li><a href="../manager/manager.php?action=budget&id={$id}">Presupuesto</a></li>
                </ul>
            </nav>
NAV2;
        }
        echo "</ul></nav>";
    }

    private static function get_projects_name_with($id){
        $db = new DB();
        $result = $db->execute_query("SELECT id, name FROM project WHERE manager_id=? AND state=?", array($id, "En proceso"));
        $names = $result->fetchAll();
        return $names;
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
                </tr>
BODY;
            }
            echo "</table>";
        }
    }

    public static function show_team_with($state){
        if(!$_GET) return;

        echo "<h1>Equipos $state</h1>";
        $db = new DB();
        if($state == "Sin asignar")
            $result = $db->execute_query("SELECT * FROM team WHERE project_id=? AND task_id IS NULL;", array($_GET['id']));
        else
            $result = $db->execute_query("SELECT * FROM team WHERE project_id=? AND task_id IS NOT NULL;", array($_GET['id']));

        if($result){
            $result->setFetchMode(PDO::FETCH_NAMED);
            $first = true;

            foreach($result as $team){
                if($first){
                    echo <<<HEAD
                    <table class='horizontalTable tasks'>
                        <tr>
                            <th>Equipo</th>
                            <th>Tarea</th>
                            <th>Acciones</th>
                        </tr>
HEAD;
                    $first = false;
                }
                echo <<<BODY
                <tr>
                    <td>{$team['name']}</td>
                    <td>{$team['task_id']}</td>
                    <td>Ver integrantes</td>
                </tr>
BODY;
            }
            echo "</table>";
        }
    }
}
?>