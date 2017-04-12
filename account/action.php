<?php
include_once '../lib/User.php';

switch ($_GET['op']) {
    case "login":
        User::login($_POST['user'], $_POST['password']);
        break;
    case "logout":
        User::logout();
        break;
}

header("Location: ../account/account.php");
?>