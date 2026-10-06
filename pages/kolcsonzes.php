<?php
    $pageTitle = 'Kölcsönzés';
    include __DIR__ . '/../includes/header.php';

    if (session_status() === PHP_SESSION_NONE) {
    session_start();
    }
    foglalas();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foglalás</title>
</head>
<body>
    <h1>Autó foglalása</h1>
   
</body>
</html>
<?php
function foglalas(){
    
}
?>

<?php include __DIR__ . '/../includes/footer.php'; ?>