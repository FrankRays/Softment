<?php
include_once '../lib/View.php';
include_once '../lib/ManagerView.php';

View::start();
ManagerView::navigation();
echo "<script src='../js/scripts.js'></script>";

if(isset($_GET['action']))
    switch($_GET['action']){
        case "task":
            $id = $_GET['id'];
            echo "<button onclick='go_to_url(\"create-task.php?id=$id\")'>Nueva tarea</button><hr>";
            ManagerView::show_tasks_with("Sin empezar");
            ManagerView::show_tasks_with("En proceso");
            ManagerView::show_tasks_with("Finalizada");
            break;
        case "team":
            ManagerView::show_teams();
            break;
        case "notify":
            ManagerView::show_notify();
            break;
        default:
            break;
    }

View::end();
?>