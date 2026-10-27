<?php

session_start();
$_SESSION = [];
session_destroy();

header('Location: /Kolcsonzo/index.php');
exit;
