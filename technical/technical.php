<?php
include_once '../lib/View.php';
include_once '../lib/TechnicalView.php';

View::start();
TechnicalView::navigation();

echo "<script src='../js/scripts.js'></script>";

if(isset($_GET['action']))
switch($_GET['action']){
    case "project":
        echo "<button onclick='go_to_url(\"create_project.php\")'>Nuevo proyecto</button><hr>";
        TechnicalView::show_projects_with("Sin asignar");
        TechnicalView::show_projects_with("En proceso");
        TechnicalView::show_projects_with("Finalizado");
        break;
    case "team":
        echo "<button onclick='go_to_url(\"create_team.php\")'>Nuevo equipo</button><hr>";
        TechnicalView::show_teams_with("Sin asignar");
        TechnicalView::show_teams_with("Asignado");
        break;
    case "resource":
        echo "<button onclick='go_to_url(\"create_resource.php\")'>Nuevo empleado</button><hr>";
        TechnicalView::show_resources_with("Sin asignar");
        TechnicalView::show_resources_with("Asignado");
        break;
    case "customer":
        echo "<button onclick='go_to_url(\"create_customer.php\")'>Nuevo cliente</button><hr>";
        TechnicalView::show_customers();
    default:
        break;
}

View::end();
?>