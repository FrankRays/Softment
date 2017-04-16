<?php
include_once '../lib/Connection.php';

class TechnicalView{
    public static function navigation(){
        echo <<<NAV
        <nav>
            <ul>
                <li><a href="../technical/technical.php?action=project">Proyectos</a></li>
                <li><a href="../technical/technical.php?action=team">Equipos</a></li>
                <li><a href="../technical/technical.php?action=resource">Empleados</a></li>
                <li><a href="../technical/technical.php?action=customer">Clientes</a></li>
                <li style="float: right;"><a href="../account/action.php?op=logout">Salir</a></li>
            </ul>
        </nav>
NAV;
    }

    public static function show_create_project(){
        echo <<<FORM
        <div class=form-container>
            <form action=technical.php?action=project method=post>
                <div class=form-section>
                    <legend>Proyecto</legend>
                    <p>Nombre del proyecto</p>
                    <input type="text" name="projectName" autofocus>
                    
                    <p>Descripción del proyecto</p>
                    <textarea name="projectDescription"></textarea>
                    
                    <p>Fecha de comienzo</p>
                    <input type="date" name="projectStart">
                    
                    <p>Fecha límite</p>
                    <input type="date" name="projectFinish">
                </div>
                
                <div class=form-section>
                    <legend>Cliente</legend>
                    
                    <p>Cliente</p>
                    <select>
                        <option default>---</option>
                        <option>ULPGC</option>
                    </select>
                    <button class=button>Nuevo cliente</button>
                </div>
                
                <div class=form-section>
                    <legend>Asignación de recursos</legend>
                    
                    <p>Jefe de proyecto</p>
                    <select>
                        <option default>---</option>
                        <option>Jefe</option>
                    </select>
                    <button class="button">Nuevo Jefe</button>
                    
                    <p>Equipos</p>
                    <div style="text-align: left;">
                        <input type="checkbox" name="team[]">Analistas<br>
                        <input type="checkbox" name="team[]">Diseñadores<br>
                        <input type="checkbox" name="team[]">Programadores<br>
                    </div>
                </div>
                <button class="button">Crear proyecto</button>
            </form>
        </div>
        <div class=clearfix></div>
FORM;
    }

    public static function show_projects_with($state){
        echo "<h1>Proyectos $state</h1>";
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
                            <th>Acciones</th>
                        </tr>
HEAD;
                    $first = false;
                }
                echo <<<BODY
                <tr>
                    <td>{$project['name']}</td>
                    <td>{$project['description']}</td>
                    <td>{$project['creation_date']}</td>
                    <td><button class=button>Editar</button> - <button class=button>Eliminar</button></td>
                </tr>
BODY;
            }
            echo "</table>";
        }
        echo "<hr>";
    }

    public static function show_create_team(){
        echo <<<FORM
        <div class=form-container>
            <form action=technical.php?action=team method=post>
                <div class=form-section>
                    <legend>Nuevo equipo</legend>
                    
                    <p>Nombre</p>
                    <input type=text autofocus>
                    
                    <p>Integrantes</p>
                    <div style="text-align: left;">
                        <input type=checkbox>Héctor Déniz Álvarez<br>
                        <input type=checkbox>Carlos Esteban León<br>
                        <input type=checkbox>Zabai Armas Herrera<br>
                    </div>
                </div>
                <button class="button">Crear equipo</button>
            </form>
        </div>
FORM;

    }

    public static function show_teams_with($state){
        echo "<h1>Equipos $state</h1>";
        $db = new DB();
        $result = $db->execute_query("SELECT * FROM team WHERE state=?", array($state));

        if($result){
            $result->setFetchMode(PDO::FETCH_NAMED);
            $first = true;

            foreach($result as $team){
                if($first){
                    echo <<<HEAD
                    <table class="horizontalTable">
                        <tr>
                            <th>Nombre</th>
                            <th>Miembros</th>
                            <th>Proyecto</th>
                            <th>Acciones</th>
                        </tr>
HEAD;
                    $first = false;
                }
                $projectName = self::get_project_name_by($team['project_id']);
                $teamMembers = self::get_team_members_from_team($team['id']);
                echo <<<BODY
                <tr>
                    <td>{$team['name']}</td>
                    <td>{$teamMembers}</td>
                    <td>{$projectName}</td>
                    <td><button class=button>Editar</button> - <button class=button>Eliminar</button></td>
                </tr>
BODY;
            }
            echo "</table><hr>";
        }
    }

    public static function show_create_resource(){
        echo <<<FORM
        <div class=form-container>
            <form action=technical.php?action=resource method=post>
                <div class=form-section>
                    <legend>Nuevo Empleado</legend>
                    
                    <p>Nombre</p>
                    <input type=text name=name autofocus>
                    
                    <p>Email</p>
                    <input type=text name=email>
                    
                    <p>Tipo</p>
                    <select>
                        <option default>---</option>
                        <option>Analista</option>
                        <option>Diseñador</option>
                        <option>Programador</option>
                    </select>
                </div>
                <button class=button>Crear empleado</button>
            </form>
        </div>
FORM;
    }

    public static function show_resources_with($state){
        echo "<h1>Recursos $state</h1>";
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
                            <th>Acciones</th>
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
                    <td><button class=button>Editar</button> - <button class=button>Eliminar</button></td>
                </tr>
BODY;
            }
            echo "</table>";
        }
        echo "<hr>";
    }

    public static function show_create_customer(){
        echo <<<FORM
        <div class="form-container">
            <form action=technical.php?action=customer method=post>
                <div class="form-section">
                    <legend>Nuevo Cliente</legend>
                    <p>Nombre</p>
                    <input type="text" name="name" autofocus>
                    
                    <p>Email</p>
                    <input type="text" name="email">
                    
                    <p>Teléfono</p>
                    <input type="text" name="telephone">
                </div>
                <button class="button">Crear cliente</button>
            </form>
        </div>
        <div class="clearfix"></div>
FORM;
    }

    public static function show_customers(){
        echo "<h1>Clientes</h1>";
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
                            <th>Acciones</th>
                        </tr>
HEAD;
                    $first = false;
                }
                echo <<<BODY
                <tr>
                    <td>{$customer['name']}</td>
                    <td>{$customer['email']}</td>
                    <td>{$customer['telephone']}</td>
                    <td><button class=button>Editar</button> - <button class=button>Eliminar</button></td>
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