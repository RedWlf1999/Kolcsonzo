<?php
require_once(__DIR__.'/../models/user.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



function onlyLogon(): void {
    if (!isset($_SESSION['user'])) {
        header('Location: /Kolcsonzo/pages/login.php?vissza=' . urlencode($_SERVER['REQUEST_URI']));
        exit;
    }
}

function onlyAdmin(): void {
    onlyLogon();
    $user = $_SESSION["user"];
    if ($user->getJog() !== 'Admin') {
        header('Location: /Kolcsonzo/index.php');
        exit;
    }
}
