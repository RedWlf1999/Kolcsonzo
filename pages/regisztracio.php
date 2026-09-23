<?php
    session_start();
    checkRegisztracio();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
</head>
<body>
    <h1>Regisztráció</h1>
    <form method="post">
        <input type="email" name="email" placeholder="E-mail"/><br>
        <input type="text" name="Vnev" placeholder="Vezetéknév"/><br>
        <input type="text" name="KNev" placeholder="Keresztnév"/><br>
        <input type="password" name="password" placeholder="Jelszó"/><br>
        <input type="password" name="password2" placeholder="Jelszó megerősítése"/><br>
        <input type="text" name="telszam" placeholder="+36301234567"/><br>

        <button type="submit">Regisztráció</button>
    </form>
</body>
</html>
<?php
function checkRegisztracio(){

}