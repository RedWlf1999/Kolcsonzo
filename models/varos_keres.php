<?php
header('Content-Type: application/json; charset=utf-8');
require_once(__DIR__.'/../models/db.php');

if (isset($_GET['irsz'])) {
    $irsz = $_GET['irsz'];
    
    
    global $conn;
    
    $sql = "SELECT telepules FROM telepulesek WHERE IRSZ = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $irsz);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode(['varos' => $row['telepules']]);
    } else {
        echo json_encode(['varos' => null]);
    }
}
?>
