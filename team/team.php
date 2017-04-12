<?php
include_once '../lib/View.php';
include_once '../lib/TeamView.php';

View::start();
TeamView::navigation();

if(isset($_GET['action']))
switch($_GET['action']){
    case "task":

        break;
    default:
        break;
}

View::end();
?>