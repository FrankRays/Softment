<?php
include_once '../lib/View.php';
include_once '../lib/TechnicalView.php';

View::start();
TechnicalView::navigation();

TechnicalView::show_create_resource();

View::end();
?>