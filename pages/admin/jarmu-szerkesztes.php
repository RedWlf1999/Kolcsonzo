<?php
require __DIR__ . '/../../includes/auth.php';
onlyAdmin();

require __DIR__ . '/../../models/car.php';


$id = (int) ($_GET['id'] ?? 0);
$auto = $id > 0 ? Car::keres($id) : null;
$ujAuto = ($id === 0);


$uzenet = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uzenet = 'Ez tezstadat, a mentés még nem kerül az adatbázisba.';
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

$kategoriak = ['Kisautó', 'Kompakt', 'Kombi', 'Egyterű', 'SUV', 'Prémium'];

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
                <label>Márka *
                    <input type="text" name="marka" value="<?= e($marka) ?>" required>
                </label>
                <label>Típus *
                    <input type="text" name="modell" value="<?= e($modell) ?>" required>
                </label>
                <label>Kategória *
                    <select name="kategoria" required>
                        <option value="">Válassz…</option>
                        <?php foreach ($kategoriak as $k): ?>
                            <option value="<?= e($k) ?>" <?= kivalasztva($k, $kategoria) ?>><?= e($k) ?></option>
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
                <label>Csomagtér (liter)
                    <input type="number" name="csomagter" value="<?= e($csomagter) ?>" min="0">
                </label>
                <label>Váltó *
                    <select name="valto" required>
                        <option value="">Válassz…</option>
                        <option value="Manuális" <?= kivalasztva('Manuális', $valto) ?>>Manuális</option>
                        <option value="Automata" <?= kivalasztva('Automata', $valto) ?>>Automata</option>
                    </select>
                </label>
                <label>Üzemanyag *
                    <select name="uzemanyag" required>
                        <option value="">Válassz…</option>
                        <option value="Benzin" <?= kivalasztva('Benzin', $uzemanyag) ?>>Benzin</option>
                        <option value="Dízel" <?= kivalasztva('Dízel', $uzemanyag) ?>>Dízel</option>
                        <option value="Hibrid" <?= kivalasztva('Hibrid', $uzemanyag) ?>>Hibrid</option>
                        <option value="Elektromos" <?= kivalasztva('Elektromos', $uzemanyag) ?>>Elektromos</option>
                    </select>
                </label>
                <label>Fogyasztás
                    <input type="text" name="fogyasztas" value="<?= e($fogyasztas) ?>" placeholder="pl. 5,2 l/100 km">
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
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> <?= $ujAuto ? 'Autó felvétele' : 'Mentés' ?>
                </button>
            </div>
        </form>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
