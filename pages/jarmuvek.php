<?php
$pageTitle = 'Járművek';
$pageCss = 'jarmuvek.css';
require __DIR__ . '/../models/car.php';

$autok = Car::osszes();
$kereses   = trim($_GET['kereses'] ?? '');
$kategoria = $_GET['kategoria'] ?? '';
$valto     = $_GET['valto'] ?? '';
$uzemanyag = $_GET['uzemanyag'] ?? '';
$arMin     = $_GET['ar_min'] ?? '';
$arMax     = $_GET['ar_max'] ?? '';
$rendezes  = $_GET['rendezes'] ?? '';
$atvetel   = $_GET['atvetel'] ?? '';
$leadas    = $_GET['leadas'] ?? '';

$kategoriak = [];
foreach ($autok as $auto) {
    $kategoriak[] = $auto->getKategoria();
}
$kategoriak = array_unique($kategoriak);
sort($kategoriak);

$talalatok = [];
foreach ($autok as $auto) {
    if ($kereses !== '' && mb_stripos($auto->getTeljesNev(), $kereses) === false) continue;
    if ($kategoria !== '' && $auto->getKategoria() !== $kategoria) continue;
    if ($valto !== '' && $auto->getValto() !== $valto) continue;
    if ($uzemanyag !== '' && $auto->getUzemanyag() !== $uzemanyag) continue;
    if ($arMin !== '' && $auto->getAr() < (int) $arMin) continue;
    if ($arMax !== '' && $auto->getAr() > (int) $arMax) continue;

    $talalatok[] = $auto;
}

if ($rendezes === 'ar_nov') {
    usort($talalatok, function ($a, $b) { return $a->getAr() <=> $b->getAr(); });
} elseif ($rendezes === 'ar_csokk') {
    usort($talalatok, function ($a, $b) { return $b->getAr() <=> $a->getAr(); });
} elseif ($rendezes === 'abc') {
    usort($talalatok, function ($a, $b) { return strcasecmp($a->getTeljesNev(), $b->getTeljesNev()); });
}

function kivalasztva($ertek, $aktualis) {
    return $ertek === $aktualis ? 'selected' : '';
}

include __DIR__ . '/../includes/header.php';
?>

<section class="page-banner">
    <h1>Autóink</h1>
</section>

<main class="page">
    <form method="get" class="filter-bar" id="szuro">
        <div class="filter-row">
            <label>Átvétel
                <input type="date" name="atvetel" value="<?= $atvetel ?>">
            </label>
            <label>Leadás
                <input type="date" name="leadas" value="<?= $leadas ?>">
            </label>
            <label class="filter-search">Keresés
                <input type="text" name="kereses" value="<?= $kereses ?>" placeholder="Márka vagy típus">
            </label>
        </div>

        <div class="filter-row">
            <label>Kategória
                <select name="kategoria">
                    <option value="">Mind</option>
                    <?php foreach ($kategoriak as $k): ?>
                        <option value="<?= e($k) ?>" <?= kivalasztva($k, $kategoria) ?>><?= e($k) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Váltó
                <select name="valto">
                    <option value="">Mind</option>
                    <option value="Manuális" <?= kivalasztva('Manuális', $valto) ?>>Manuális</option>
                    <option value="Automata" <?= kivalasztva('Automata', $valto) ?>>Automata</option>
                </select>
            </label>
            <label>Üzemanyag
                <select name="uzemanyag">
                    <option value="">Mind</option>
                    <option value="Benzin" <?= kivalasztva('Benzin', $uzemanyag) ?>>Benzin</option>
                    <option value="Dízel" <?= kivalasztva('Dízel', $uzemanyag) ?>>Dízel</option>
                    <option value="Hibrid" <?= kivalasztva('Hibrid', $uzemanyag) ?>>Hibrid</option>
                    <option value="Elektromos" <?= kivalasztva('Elektromos', $uzemanyag) ?>>Elektromos</option>
                </select>
            </label>
            <label class="filter-price">Ár (Ft/nap)
                <span class="price-range">
                    <input type="number" name="ar_min" value="<?= e($arMin) ?>" placeholder="min" min="0" step="1000">
                    –
                    <input type="number" name="ar_max" value="<?= e($arMax) ?>" placeholder="max" min="0" step="1000">
                </span>
            </label>
        </div>

        <div class="filter-actions">
            <a href="jarmuvek.php" class="btn-secondary">Szűrők törlése</a>
            <button type="submit" class="btn-primary">Szűrés</button>
        </div>
    </form>

    <div class="results-bar">
        <p><strong><?= count($talalatok) ?></strong> autó</p>
        <label>Rendezés:
            <select name="rendezes" form="szuro" onchange="this.form.submit()">
                <option value="">Alapértelmezett</option>
                <option value="ar_nov" <?= kivalasztva('ar_nov', $rendezes) ?>>Ár szerint növekvő</option>
                <option value="ar_csokk" <?= kivalasztva('ar_csokk', $rendezes) ?>>Ár szerint csökkenő</option>
                <option value="abc" <?= kivalasztva('abc', $rendezes) ?>>Név szerint (A–Z)</option>
            </select>
        </label>
    </div>

    <?php if (count($talalatok) === 0): ?>
        <p class="no-results">Nincs a szűrésnek megfelelő autó.</p>
    <?php else: ?>
        <div class="car-grid">
            <?php foreach ($talalatok as $auto): ?>
                <?php $link = 'jarmu.php?' . http_build_query(['id' => $auto->getId(), 'atvetel' => $atvetel, 'leadas' => $leadas]); ?>
                <a href="<?= e($link) ?>" class="car-card">
                    <div class="car-card-head">
                        <div>
                            <p class="car-category"><?= e($auto->getKategoria()) ?></p>
                            <h3><?= e($auto->getTeljesNev()) ?></h3>
                        </div>
                        <span class="btn-accent">Bérlés <i class="fa-solid fa-chevron-right"></i></span>
                    </div>

                    <img src="/Kolcsonzo/assets/pics/cars/<?= e($auto->getKep()) ?>" alt="<?= e($auto->getTeljesNev()) ?>">

                    <ul class="car-specs">
                        <li><i class="fa-solid fa-user-group"></i> <?= e($auto->getUlesek()) ?> ülés</li>
                        <li><i class="fa-solid fa-suitcase"></i> <?= e($auto->getCsomagter()) ?> l</li>
                        <li><i class="fa-solid fa-gears"></i> <?= e($auto->getValto()) ?></li>
                        <li><i class="fa-solid fa-gas-pump"></i> <?= e($auto->getUzemanyag()) ?></li>
                        <li><i class="fa-solid fa-calendar"></i> <?= e($auto->getEv()) ?></li>
                    </ul>

                    <div class="car-footer">
                        <span class="car-price-label">Napi díj</span>
                        <strong class="car-price"><?= number_format($auto->getAr(), 0, ',', ' ') ?> Ft</strong>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>