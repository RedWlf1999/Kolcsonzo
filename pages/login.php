<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
</head>
<body>

    <form method="post">
        <input type="email" name="email" placeholder="E-mail"/><br>
        <input type="password" name="password" placeholder="Jelszó"/><br>
        <button type="submit">Bejelentkezés</button>
    </form>
    
</body>
</html>