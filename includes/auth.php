<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function onlyLogon(): void {
    if (!isset($_SESSION['role'])) {
        header('Location: /Kolcsonzo/pages/login.php?vissza=' . urlencode($_SERVER['REQUEST_URI']));
        exit;
    }
}

function onlyAdmin(): void {
    onlyLogon();
    if ($_SESSION['role'] !== 'admin') {
        header('Location: /Kolcsonzo/index.php');
        exit;
    }
}
