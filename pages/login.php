<?php
session_start();
require __DIR__ . '/../includes/teszt-felhasznalok.php';

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $jelszo = $_POST['password'] ?? '';
    $felhasznalo = tesztBelepes($email, $jelszo);

    if ($felhasznalo) {
        session_regenerate_id(true);
        $_SESSION['role'] = $felhasznalo['role'];
        $_SESSION['name'] = $felhasznalo['nev'];
        $_SESSION['email'] = $felhasznalo['email'];


        $vissza = $_GET['vissza'] ?? '';
        if (str_starts_with($vissza, '/Kolcsonzo/')) {
            header('Location: ' . $vissza);
        } elseif ($felhasznalo['role'] === 'admin') {
            header('Location: /Kolcsonzo/pages/admin/index.php');
        } else {
            header('Location: /Kolcsonzo/index.php');
        }
        exit;
    }

    $error = 'Hibás e-mail vagy jelszó.';
}
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
        <?php if ($error !== ''): ?>
            <p class="alert-error"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="post">
            <div class="input-icon">
                <i class="fa-solid fa-user"></i>
                <input type="email" name="email" placeholder="E-mail" value="<?= htmlspecialchars($email) ?>" required>
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
        <div class="test-accounts">
            <strong>Teszt fiókok</strong>
            <span>Admin: admin@admin.hu / admin</span>
            <span>Felhasználó: user@user.hu / user</span>
        </div>
    </main>
</body>
</html>