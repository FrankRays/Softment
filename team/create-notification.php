<?php
include_once '../lib/View.php';
include_once '../lib/TeamView.php';

View::start();
TeamView::navigation();

TeamView::show_create_notification();

View::end();
?>