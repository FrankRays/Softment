<?php
include_once '../lib/Connection.php';
class TechnicalView{
    public static function navigation(){
        echo <<<NAV
        <nav>
            <ul>
                <li><a href="../technical/technical.php?action=project">Proyectos</a></li>
                <li><a href="../technical/technical.php?action=resource">Recursos</a></li>
                <li><a href="../technical/technical.php?action=customer">Clientes</a></li>
                <li style="float: right;"><a href="../account/action.php?op=logout">Salir</a></li>
            </ul>
        </nav>
NAV;
    }

    public static function show_projects_with($state){
        echo "<h1 style='color: #2c3e50; margin: 20px;'>Proyectos $state</h1>";
        $db = new DB();
        $result = $db->execute_query("SELECT * FROM project WHERE state=?;", array($state));

        if($result){
            $result->setFetchMode(PDO::FETCH_NAMED);
            $first = true;

            foreach($result as $project){
                if($first){
                    echo <<<HEAD
                    <table class='horizontalTable projects'>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Fecha Creación</th>
                        </tr>
HEAD;
                    $first = false;
                }
                echo <<<BODY
                <tr>
                    <td>{$project['name']}</td>
                    <td>{$project['description']}</td>
                    <td>{$project['creation_date']}</td>
                </tr>
BODY;
            }
            echo "</table>";
        }
        echo "<hr>";
    }

    public static function show_resources_with($state){
        echo "<h1 style='color: #2c3e50; margin: 20px;'>Recursos $state</h1>";
        $db = new DB();
        $result = $db->execute_query("SELECT * FROM resource WHERE state=?;", array($state));

        if($result){
            $result->setFetchMode(PDO::FETCH_NAMED);
            $first = true;

            foreach($result as $resource){
                if($first){
                    echo <<<HEAD
                    <table class='horizontalTable resources'>
                        <tr>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Proyecto</th>
                        </tr>
HEAD;
                    $first = false;
                }
                $projectName = self::get_project_name_by($resource['project_id']);
                echo <<<BODY
                <tr>
                    <td>{$resource['type']}</td>
                    <td>{$resource['name']}</td>
                    <td>{$projectName}</td>
                </tr>
BODY;
            }
            echo "</table>";
        }
        echo "<hr>";
    }

    private static function get_project_name_by($id){
        if($id == "") return "---";
        $db = new DB();
        $result = $db->execute_query("SELECT name FROM project WHERE id=?;", array($id));
        $name = $result->fetch();
        return $name[0];
    }

    public static function show_customers(){
        echo "<h1 style='color: #2c3e50; margin: 20px;'>Clientes</h1>";
        $db = new DB();
        $result = $db->execute_query("SELECT * FROM customer;");

        if($result){
            $result->setFetchMode(PDO::FETCH_NAMED);
            $first = true;

            foreach($result as $customer){
                if($first){
                    echo <<<HEAD
                    <table class='horizontalTable resources'>
                        <tr>
                            <th>Empresa</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                        </tr>
HEAD;
                    $first = false;
                }
                echo <<<BODY
                <tr>
                    <td>{$customer['name']}</td>
                    <td>{$customer['email']}</td>
                    <td>{$customer['telephone']}</td>
                </tr>
BODY;
            }
            echo "</table>";
        }
        echo "<hr>";
    }
}
?>