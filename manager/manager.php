<?php
include_once '../lib/View.php';
include_once '../lib/ManagerView.php';

View::start();
ManagerView::navigation();

if(isset($_GET['action']))
    switch($_GET['action']){
        case "task":
            ManagerView::show_tasks_with("Sin empezar");
            ManagerView::show_tasks_with("En proceso");
            ManagerView::show_tasks_with("Finalizada");
            break;
        case "team":
            ManagerView::show_team_with("Sin asignar");
            ManagerView::show_team_with("Asignado");
            break;
        default:
            break;
    }

View::end();
?>