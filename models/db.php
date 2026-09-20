<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";

// kapcsolódás
$conn = mysqli_connect($servername, $username, $password, $dbname);

// checkoljuk létrejött-e a kapcsolat
if (!$conn) {
    die("Sikertelen kapcsolódás: " . mysqli_connect_error());
}