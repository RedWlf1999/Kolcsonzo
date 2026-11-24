<?php
require __DIR__ . '/../../includes/auth.php';
require_once(__DIR__.'/../../models/user.php');
require_once(__DIR__.'/../../models/db.php');
$user=$_SESSION["user"];
onlyAdmin();

require_once __DIR__ . '/../../models/car.php';
require_once __DIR__ . '/../../models/sql.php';


$rndsz =  $_GET['rndsz'] ?? '';
$auto = $rndsz !== '' ? Car::Keres($rndsz) : null;
$ujAuto = ($rndsz === '');


$uzenet = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
   AutoAdatok();
}


$marka      = $auto ? $auto->getMarka() : '';
$modell     = $auto ? $auto->getModell() : '';
$kategoria  = $auto ? $auto->getKategoria() : '';
$ar         = $auto ? $auto->getAr() : '';
$ulesek     = $auto ? $auto->getUlesek() : 5;
$csomagter  = $auto ? $auto->getCsomagter() : '';
$valto      = $auto ? $auto->getValto() : '';
$uzemanyag  = $auto ? $auto->getUzemanyag() : '';
$ev         = $auto ? $auto->getEv() : date('Y');
$fogyasztas = $auto ? $auto->getFogyasztas() : '';
$leiras     = $auto ? $auto->getLeiras() : '';

$kategoriak = Sql::Kategoriak();
$markak = Sql::AutoMarkak();

function kivalasztva($ertek, $aktualis) {
    return $ertek === $aktualis ? 'selected' : '';
}

$pageTitle = $ujAuto ? 'Új autó' : 'Autó szerkesztése';
$pageCss = 'admin.css';
include __DIR__ . '/../../includes/header.php';
?>

<main class="page">
    <a href="jarmuvek.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Vissza a járművekhez</a>

    <?php if (!$ujAuto && !$auto): ?>
        <p class="empty">Ez az autó nem található.</p>
    <?php else: ?>
        <div class="admin-head">
            <div>
                <h1><?= $ujAuto ? 'Új autó felvétele' : 'Szerkesztés: ' . e($auto->getTeljesNev()) ?></h1>
                <p>A csillaggal (*) jelölt mezők kitöltése kötelező.</p>
            </div>
        </div>

        <?php if ($uzenet !== ''): ?>
            <p class="notice"><i class="fa-solid fa-circle-info"></i> <?= e($uzenet) ?></p>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="panel admin-form">
            <h2>Alapadatok</h2>
            <div class="form-grid">
             <label>Rendszám *
                    <input type="text" name="rendszam" value="<?= e($rndsz) ?>" required>
                </label>    
                 <label>Márka *
                    <select name="marka" required>
                        <option value="">Válassz…</option>
                        <?php foreach ($markak as $id => $nev): ?>
                            <option value="<?= $id ?>" <?= kivalasztva($nev, $marka) ?>>
                                <?= e($nev) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>Típus *
                    <input type="text" name="modell" value="<?= e($modell) ?>" required>
                </label>
                <label>Kategória *
                    <select name="kategoria" required>
                        <option value="">Válassz…</option>
                        <?php foreach ($kategoriak as $id => $nev): ?>
                            <option value="<?= $id ?>" <?= kivalasztva($nev, $kategoria) ?>>
                                <?= e($nev) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>Napi ár (Ft) *
                    <input type="number" name="ar" value="<?= e($ar) ?>" min="0" step="500" required>
                </label>
                <label>Évjárat *
                    <input type="number" name="ev" value="<?= e($ev) ?>" min="1990" max="<?= date('Y') + 1 ?>" required>
                </label>
            </div>

            <h2>Műszaki adatok</h2>
            <div class="form-grid">
                <label>Ülések száma *
                    <input type="number" name="ulesek" value="<?= e($ulesek) ?>" min="1" max="9" required>
                </label>
                <label>Csomagtér (liter) *
                    <input type="number" name="csomagter" value="<?= e($csomagter) ?>" min="0" required>
                </label>
                <label>Váltó *
                    <select name="valto" required>
                        <option value="">Válassz…</option>
                        <option value="1" <?= kivalasztva('Manuális', $valto) ?>>Manuális</option>
                        <option value="2" <?= kivalasztva('Automata', $valto) ?>>Automata</option>
                    </select>
                </label>
                <label>Üzemanyag *
                    <select name="uzemanyag" required>
                        <option value="">Válassz…</option>
                        <option value="1" <?= kivalasztva('Benzin', $uzemanyag) ?>>Benzin</option>
                        <option value="2" <?= kivalasztva('Dízel', $uzemanyag) ?>>Dízel</option>
                        <option value="3" <?= kivalasztva('Hibrid', $uzemanyag) ?>>Hibrid</option>
                        <option value="4" <?= kivalasztva('Elektromos', $uzemanyag) ?>>Elektromos</option>
                    </select>
                </label>
                <label>Fogyasztás *
                    <input type="text" name="fogyasztas" value="<?= e($fogyasztas) ?>" placeholder="pl. 5,2 l/100km" required>
                </label>
            </div>

            <h2>Leírás és kép</h2>
            <label>Leírás
                <textarea name="leiras" rows="4"><?= e($leiras) ?></textarea>
            </label>

            <div class="image-field">
                <?php if ($auto): ?>
                    <img class="image-preview" src="/Kolcsonzo/assets/pics/cars/<?= e($auto->getKep()) ?>" alt="Jelenlegi kép">
                <?php endif; ?>
                <label><?= $auto ? 'Új kép feltöltése (ha cserélnéd)' : 'Kép *' ?>
                    <input type="file" name="kep" accept="image/*" <?= $ujAuto ? 'required' : '' ?>>
                </label>
            </div>

            <div class="form-actions">
                <a href="jarmuvek.php" class="btn-secondary">Mégse</a>
                <button type="submit" name="submit" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> <?= $ujAuto ? 'Autó felvétele' : 'Mentés' ?>
                </button>
            </div>
        </form>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; 
function AutoAdatok(){
    global $uzenet;
    global $user;
    global $auto;
    global $ujAuto;
    global $rndsz;
    $Rndsz = trim($_POST["rendszam"]);
    $Marka=(int)trim($_POST["marka"]);
    $Modell =trim( $_POST["modell"]);
    $Kat  = (int)trim( $_POST["kategoria"]);
    $Ar =(int) trim( $_POST["ar"]);
    $Ulesek = (int)trim( $_POST["ulesek"]);
    $Csomagter  =(int) trim( $_POST["csomagter"]);
    $Valto  = (int)trim( $_POST["valto"]);
    $Uzemanyag  =(int)  trim( $_POST["uzemanyag"]);
    $Ev = (int)trim( $_POST["ev"]);
    $Fogyasztas  = (float)trim( $_POST["fogyasztas"]);
    $Leiras = trim( $_POST["leiras"]);
    $ujFajlnev="";
    
    if($Rndsz=='' || $Marka=='' || $Modell=='' || $Kat=='' || $Ar=='' || $Ulesek=='' || $Csomagter=='' ||
         $Valto=='' || $Uzemanyag=='' || $Ev=='' || $Fogyasztas==''){
            $uzenet="Hiányzó mező(k) kitöltése kötelező!";
        }
        else{
            $kepNev = $auto ? $auto->getKep() : '';
            $feltoltesHiba = false;
                  
        // Megnézzük, választott-e ki új fájlt a felhasználó
        if (isset($_FILES['kep']) && $_FILES['kep']['error'] !== UPLOAD_ERR_NO_FILE) {
            
            if ($_FILES['kep']['error'] === UPLOAD_ERR_OK) {
                $engedelyezettKiterjesztesek = ['jpg', 'jpeg', 'png'];
                $eredetiNev = $_FILES['kep']['name'];
                $kiterjesztes = strtolower(pathinfo($eredetiNev, PATHINFO_EXTENSION));

                // 1. Kiterjesztés ellenőrzése
                if (!in_array($kiterjesztes, $engedelyezettKiterjesztesek)) {
                    $uzenet = "Csak JPG vagy PNG formátumú kép tölthető fel!";
                    $feltoltesHiba = true;
                } else {
                    // 2. Egyedi fájlnév generálása, hogy ne írják felül egymást (pl. 65a8f9b2c1_kpNv.jpg)
                    $ujFajlnev = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', basename($eredetiNev));
                    $celMappa = __DIR__ . '/../../assets/pics/cars/';
                    
                    if (move_uploaded_file($_FILES['kep']['tmp_name'], $celMappa . $ujFajlnev)) {
                        // Ha szerkesztésnél lecseréltük a képet, a régit érdemes törölni a tárhelyről
                        if ($auto && $kepNev !== '' && file_exists($celMappa . $kepNev)) {
                            unlink($celMappa . $kepNev);
                        }
                        $kepNev = $ujFajlnev; // Ezt a fájlnevet mentjük az adatbázisba!
                    } else {
                        $uzenet = "Hiba történt a kép szerverre mentésekor.";
                        $feltoltesHiba = true;
                    }
                }
            } else {
                $uzenet = "Hiba a fájl feltöltése során (hibakód: " . $_FILES['kep']['error'] . ").";
                $feltoltesHiba = true;
            }

        } elseif ($ujAuto) {
            // Új autó felvételénél kötelező a kép, ha nem választott ki semmit, hibát dobunk
            $uzenet = "Új autó felvételénél a kép feltöltése kötelező!";
            $feltoltesHiba = true;
        }

        // Csak akkor mentünk az adatbázisba, ha a képfeltöltés is rendben lezajlott
        if (!$feltoltesHiba) {
            if($ujAuto){
                        $uzenet = $user->AutoHozzadasa(
                                    $Rndsz,
                                    $Marka,
                                    $Modell,
                                    $Kat,
                                    $Ar,
                                    $Ulesek,
                                    $ujFajlnev,
                                    $Csomagter,
                                    $Valto,
                                    $Uzemanyag,
                                    $Ev,
                                    $Fogyasztas,
                                    $Leiras
                                    );
            }else{
                $uzenet = $user->AutoAdatokFrisstese(
                                    $rndsz,
                                    $Rndsz,
                                    $Marka,
                                    $Modell,
                                    $Kat,
                                    $Ar,
                                    $Ulesek,
                                    $kepNev,
                                    $Csomagter,
                                    $Valto,
                                    $Uzemanyag,
                                    $Ev,
                                    $Fogyasztas,
                                    $Leiras
                                    );
                
                
            }
        }
              
    }
}

