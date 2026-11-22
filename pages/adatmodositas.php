<?php
require __DIR__ . '/../models/db.php';
require __DIR__ . '/../models/user.php';
require __DIR__ . '/../includes/auth.php';

$user=$_SESSION["user"];
onlyLogon();

require __DIR__ . '/../includes/teszt-felhasznalok.php';
$adatSiker = '';
$jelszoSiker = '';
$adatHibak = [];
$jelszoHibak = [];
changeData();


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
                    <input type="text" name="vnev" value="<?=  $user->getVnev()?>" required>
                </label>
                <label>Keresztnév
                    <input type="text" name="knev" value="<?=  $user->getknev()?>" required>
                </label>
               
            </div>
            <label>E-mail
                <input type="email" name="email" value="<?=  $user->getEmail()?>"  placeholder="E-mail cím" required>
            </label>
            <label>Telefonszám
                <input type="tel" name="telefon" value="<?=  $user->getTelefonszam()?>" placeholder="+36301234567">
            </label>
             <label>Személyigazolvány/Útlevél
                    <input type="text" name="szemelyiUtlevel" value="<?=  $user->getSzemelyUtlevel()?>" placeholder="Személyigazolványszám / Útlevél száma" required>
                </label>
                 <label>Jogosítvány
                <input type="text" name="jogsi" value="<?=  $user->getJogositvany()?>" placeholder="Jogosítvány száma">
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



<?php include __DIR__ . '/../includes/footer.php'; 

function changeData(){
                global $adatSiker;
                global $jelszoSiker;
                global $adatHibak;
                global $jelszoHibak ;
                global $user;
                //$nevReszek = explode(' ', $_SESSION['name'] ?? '', 2);
                $vnev    = $user->getVnev() ??'';
                $knev    = $user->getKnev() ??'';
                $email   = $user->getEmail() ??'';
                $telefon = $user->getTelefonszam() ??'';
                $jogsi = $user->getSzemelyUtlevel() ??'';
                $utlevelSzemelyi = $user->getJogositvany() ??'';


                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adatok'])) {
                        $vnev    = trim($_POST['vnev'] ?? '') ?: $vnev;
                        $knev    = trim($_POST['knev'] ?? '') ?:  $knev ;
                        $email   = trim($_POST['email'] ?? '') ?: $email ;
                        $telefon = trim($_POST['telefon'] ?? '') ?:  $telefon;
                        $jogsi = trim($_POST['jogsi'] ?? '') ?: $jogsi;
                        $utlevelSzemelyi = trim($_POST['szemelyiUtlevel'] ?? '') ?: $utlevelSzemelyi;


                        if ($vnev === '' || $knev === '') {
                            $adatHibak[] = 'A vezeték- és keresztnév megadása kötelező.';
                        }
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $adatHibak[] = 'Érvénytelen e-mail cím.';
                        }
                        if ($telefon !== '' && !preg_match('/^\+?[0-9 ]{9,16}$/', $telefon)) {
                            $adatHibak[] = 'A telefonszám formátuma nem megfelelő (pl. +36301234567).';
                        }
                        if ($jogsi !== '' && !preg_match('/^[A-Z]{2}[0-9]{6}$/', $jogsi)) {
                            $adatHibak[] = 'A jogositvány formátuma nem megfelelő (pl. AB123456).';
                        }
                        if ($utlevelSzemelyi !== '' && !preg_match('/^([0-9]{6}[A-Z]{2}|[A-Z]{2}[0-9]{6,7})$/', $utlevelSzemelyi)) {
                            $adatHibak[] = 'Az útlevél/személyigazolvány formátuma nem megfelelő (pl. 123456AB vagy AB1234567).';
                        }

                        if (count($adatHibak) === 0) {
                        $user->setKnev($knev);
                        $user->setVnev($vnev);
                        $user->setEmail($email);
                        $user->setTelefonszam($telefon);
                        $user->setSzemelyUtlevel($utlevelSzemelyi);
                        $user->setJogositvany($jogsi);
                        $user->AdatokModositasa();

                        $adatSiker = 'Az adataidat elmentettük.';
                    }
                }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jelszo_modositas'])) {
                $jelenlegi = $_POST['jelenlegi_jelszo'] ?? '';
                $uj        = $_POST['password'] ?? '';
                $uj2       = $_POST['password2'] ?? '';


                if (!$user->getJelszo()|| !password_verify($jelenlegi, $user->getJelszo())) {
                    $jelszoHibak[] = 'A jelenlegi jelszó nem megfelelő.';
                }
                if (strlen($uj) < 8 || !preg_match('/[0-9]/', $uj) || !preg_match('/[!@#$%&*?._-]/', $uj)) {
                    $jelszoHibak[] = 'Az új jelszó legalább 8 karakter legyen, és tartalmazzon számot és speciális karaktert.';
                }
                if ($uj !== $uj2) {
                    $jelszoHibak[] = 'A két új jelszó nem egyezik.';
                }

                if (count($jelszoHibak) === 0) {
                    $jelszoSiker = 'A jelszó módosítása rendben.';
                    $user->JelszoModositas($uj);
                }
            }
}
