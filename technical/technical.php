<?php
include_once '../lib/View.php';
include_once '../lib/TechnicalView.php';

View::start();
TechnicalView::navigation();

if(isset($_GET['action']))
switch($_GET['action']){
    case "project":
        TechnicalView::show_projects_with("Sin asignar");
        TechnicalView::show_projects_with("En proceso");
        TechnicalView::show_projects_with("Finalizado");
        break;
    case "resource":
        TechnicalView::show_resources_with("Sin asignar");
        TechnicalView::show_resources_with("Asignado");
        break;
    case "customer":
        TechnicalView::show_customers();
    default:
        break;
}

View::end();
?>