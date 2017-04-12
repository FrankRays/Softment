<?php
include_once '../lib/User.php';
if (!User::getLoggedUser()) header("Location: ../account/login.php");

switch (User::getLoggedUser()['type']) {
    case 1:
        header("Location: ../technical/technical.php?action=project");
        break;
    case 2:
        header("Location: ../manager/manager.php");
        break;
    case 3:
        header("Location: ../team/team.php?action=task");
        break;
    default:
        break;
}
?>