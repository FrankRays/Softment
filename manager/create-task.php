<?php
include_once '../lib/View.php';
include_once '../lib/ManagerView.php';

View::start();
ManagerView::navigation();

ManagerView::show_create_task();

View::end();
?>