<?php
    session_start();

    $szerepKor = $_SESSION['role'] ?? null;
    $bejelentkezettNev = $_SESSION['name'] ?? '';
    
?>


<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $pageTitle ?></title>

        <link rel="stylesheet" href="/Kolcsonzo/assets/css/style.css">
        <link rel="stylesheet" href="/Kolcsonzo/assets/css/layout.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
    <body>
        <header class="site-header">
                <a href="/Kolcsonzo/index.php" class="brand"><img src="/Kolcsonzo/assets/pics/logo.png" alt="">Autókölcsönző</a>

                <nav class="main-nav">
                    <?php if ($szerepKor === 'admin'): ?>
                        <a href="/Kolcsonzo/pages/admin/index.php">Áttekintés</a>
                        <a href="/Kolcsonzo/pages/admin/jarmuvek.php">Járművek</a>
                        <a href="/Kolcsonzo/pages/admin/foglalasok.php">Foglalások</a>
                    <?php else: ?>
                        <a href="/Kolcsonzo/pages/jarmuvek.php">Járművek</a>
                        <a href="/Kolcsonzo/pages/kolcsonzes.php">Kölcsönzés</a>
                        <a href="Kolcsonzo/pages/foglalasaim.php">Foglalásaim</a>
                        <a href="#">Kapcsolat</a>
                    <?php endif; ?> 
                </nav>

                <div class="user-menu">
                    <?php if ($szerepKor): ?>
                        <span><i class="fa-solid fa-user"></i> <?= $bejelentkezettNev ?></span>
                        <a href="/Kolcsonzo/pages/logout.php" class="btn-outline">Kijelentkezés</a>
                    <?php else: ?>
                        <a href="/Kolcsonzo/pages/login.php">Bejelentkezés</a>
                        <a href="/Kolcsonzo/pages/regisztracio.php" class="btn-outline">Regisztráció</a>
                    <?php endif; ?>

                </div>
        </header>
    </body>

</html>