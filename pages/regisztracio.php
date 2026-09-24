<?php
    session_start();
    checkRegisztracio();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <link rel="stylesheet" href="/Kolcsonzo/assets/css/style.css">
    <link rel="stylesheet" href="/Kolcsonzo/assets/css/auth.css">
</head>
<body class="auth-page">
    <main>
        <img src="/Kolcsonzo/assets/pics/logo.png" alt="" class="auth-logo">
        <h1>Regisztráció</h1>
        <p class="subtitle">Hozd létre a fiókodat.</p>
        <form method="post">
            <input type="email" name="email" id="email" placeholder="E-mail"  required/><br>
            <input type="text" name="Vnev" id="Vnev" placeholder="Vezetéknév" required/><br>
            <input type="text" name="KNev" id="KNev" placeholder="Keresztnév" required/><br>
            <input type="password" name="password" id="password" placeholder="Jelszó" required/><br>
            <input type="password" name="password2" id="password2" placeholder="Jelszó megerősítése" required/><br>
            <input type="text" name="telszam" id="telszam" placeholder="+36301234567" required/><br>

            <label class="checkbox"><input type="checkbox" name="aszf" required>Elfogadom a felhasználási feltételeket</label>

            <button type="submit">Regisztráció</button>

        </form>

        <p class="register-text">Már van fiókod? <a href="login.php">Jelentkezz be!</a></p>

    </main>
    <script src="/Kolcsonzo/assets/js/regisztracio.js"></script>    
</body>
</html>
<?php
function checkRegisztracio(){

}