<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="/Kolcsonzo/assets/css/style.css">
    <link rel="stylesheet" href="/Kolcsonzo/assets/css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="auth-page">
    <main>
        <img src="/Kolcsonzo/assets/pics/logo.png" alt="" class="auth-logo">
        <h1>Autókölcsönző</h1>
        <p class="subtitle">Jelentkezz be az autófoglaláshoz.</p>
        <form method="post">
            <div class="input-icon">
                <i class="fa-solid fa-user"></i>
                <input type="email" name="email" placeholder="E-mail" required>
            </div>
            <div class="input-icon">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" placeholder="Jelszó" required>
            </div>
            <button type="submit">Bejelentkezés</button>
        </form>
        <p class="register-text">
            Még nincs fiókod? <a href="regisztracio.php">Regisztrálj!</a>
        </p>
    </main>
</body>
</html>