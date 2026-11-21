<?php
require __DIR__ . '/../includes/auth.php';
onlyLogon();

require __DIR__ . '/../includes/teszt-felhasznalok.php';

$nevReszek = explode(' ', $_SESSION['name'] ?? '', 2);
$vnev    = $nevReszek[0];
$knev    = $nevReszek[1] ?? '';
$email   = $_SESSION['email'] ?? '';
$telefon = $_SESSION['telefon'] ?? '';

$adatHibak = [];
$adatSiker = '';
$jelszoHibak = [];
$jelszoSiker = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adatok'])) {
    $vnev    = trim($_POST['vnev'] ?? '');
    $knev    = trim($_POST['knev'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $telefon = trim($_POST['telefon'] ?? '');

    if ($vnev === '' || $knev === '') {
        $adatHibak[] = 'A vezeték- és keresztnév megadása kötelező.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $adatHibak[] = 'Érvénytelen e-mail cím.';
    }
    if ($telefon !== '' && !preg_match('/^\+?[0-9 ]{9,16}$/', $telefon)) {
        $adatHibak[] = 'A telefonszám formátuma nem megfelelő (pl. +36301234567).';
    }

    if (count($adatHibak) === 0) {
        $_SESSION['name']    = $vnev . ' ' . $knev;
        $_SESSION['email']   = $email;
        $_SESSION['telefon'] = $telefon;
        $adatSiker = 'Az adataidat elmentettük.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jelszo_modositas'])) {
    $jelenlegi = $_POST['jelenlegi_jelszo'] ?? '';
    $uj        = $_POST['password'] ?? '';
    $uj2       = $_POST['password2'] ?? '';

    // a bejelentkezett teszt felhasználó megkeresése a szerepköre alapján
    $tarolt = null;
    foreach (TESZT_FELHASZNALOK as $f) {
        if ($f['role'] === $_SESSION['role']) {
            $tarolt = $f;
        }
    }

    if (!$tarolt || !password_verify($jelenlegi, $tarolt['jelszo'])) {
        $jelszoHibak[] = 'A jelenlegi jelszó nem megfelelő.';
    }
    if (strlen($uj) < 8 || !preg_match('/[0-9]/', $uj) || !preg_match('/[!@#$%&*?._-]/', $uj)) {
        $jelszoHibak[] = 'Az új jelszó legalább 8 karakter legyen, és tartalmazzon számot és speciális karaktert.';
    }
    if ($uj !== $uj2) {
        $jelszoHibak[] = 'A két új jelszó nem egyezik.';
    }

    if (count($jelszoHibak) === 0) {
        $jelszoSiker = 'A jelszó módosítása rendben. (Ez ál-adat, az új jelszó még nem mentődik el.)';
    }
}

$pageTitle = 'Adataim';
$pageCss = 'adatmodositas.css';
include __DIR__ . '/../includes/header.php';
?>

<section class="page-banner">
    <h1>Adataim</h1>
</section>

<main class="page">
    <div class="profile-layout">

        <form method="post" class="profile-card">
            <h2><i class="fa-solid fa-user"></i> Személyes adatok</h2>

            <?php if ($adatSiker !== ''): ?>
                <p class="msg msg-ok"><i class="fa-solid fa-circle-check"></i> <?= e($adatSiker) ?></p>
            <?php endif; ?>
            <?php foreach ($adatHibak as $hiba): ?>
                <p class="msg msg-error"><i class="fa-solid fa-circle-exclamation"></i> <?= e($hiba) ?></p>
            <?php endforeach; ?>

            <div class="form-row">
                <label>Vezetéknév
                    <input type="text" name="vnev" value="<?= e($vnev) ?>" required>
                </label>
                <label>Keresztnév
                    <input type="text" name="knev" value="<?= e($knev) ?>" required>
                </label>
            </div>
            <label>E-mail
                <input type="email" name="email" value="<?= e($email) ?>" required>
            </label>
            <label>Telefonszám
                <input type="tel" name="telefon" value="<?= e($telefon) ?>" placeholder="+36301234567">
            </label>

            <button type="submit" name="adatok" class="btn-primary">Mentés</button>
        </form>

        <form method="post" class="profile-card">
            <h2><i class="fa-solid fa-lock"></i> Jelszó módosítása</h2>

            <?php if ($jelszoSiker !== ''): ?>
                <p class="msg msg-ok"><i class="fa-solid fa-circle-check"></i> <?= e($jelszoSiker) ?></p>
            <?php endif; ?>
            <?php foreach ($jelszoHibak as $hiba): ?>
                <p class="msg msg-error"><i class="fa-solid fa-circle-exclamation"></i> <?= e($hiba) ?></p>
            <?php endforeach; ?>

            <label>Jelenlegi jelszó
                <input type="password" name="jelenlegi_jelszo" required>
            </label>
            <label>Új jelszó
                <input type="password" name="password" id="password" required>
                <small>Legalább 8 karakter, egy szám és egy speciális karakter (pl. ! ? @ #).</small>
            </label>
            <label>Új jelszó megerősítése
                <input type="password" name="password2" id="password2" required>
            </label>

            <button type="submit" name="jelszo_modositas" class="btn-secondary">Jelszó módosítása</button>
        </form>

    </div>
</main>

<script src="/Kolcsonzo/assets/js/regisztracio.js"></script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
