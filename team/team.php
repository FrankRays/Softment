<?php
include_once '../lib/View.php';
include_once '../lib/TeamView.php';

View::start();
TeamView::navigation();
echo "<script src='../js/scripts.js'></script>";

if(isset($_GET['action']))
switch($_GET['action']){
    case "task":
        TeamView::show_tasks_with("Sin empezar");
        TeamView::show_tasks_with("En proceso");
        TeamView::show_tasks_with("Finalizada");
        break;
    case "noti":
        echo "<button onclick='go_to_url(\"../team/create-notification.php\")'>Nueva notificacion</button>";
        TeamView::show_notifications_with("Pendiente");
        TeamView::show_notifications_with("Resuelta");
        break;
    default:
        break;
}

View::end();
?>