<?php
session_start();
require __DIR__ . '/../models/car.php';

if (!isset($_SESSION['role'])) {
    header('Location: login.php?vissza=' . urlencode($_SERVER['REQUEST_URI']));
    exit;
}

$autok = Car::osszes();

$valasztottId = (int) ($_GET['auto_id'] ?? 0);
$atvetel = $_GET['atvetel'] ?? '';
$leadas  = $_GET['leadas'] ?? '';
$ma = date('Y-m-d');

$legkesobbiSzuletes = date('Y-m-d', strtotime('-21 years'));

$legkesobbiJogsi = date('Y-m-d', strtotime('-1 year'));

$autokJs = [];
foreach ($autok as $a) {
    $autokJs[$a->getId()] = [
        'nev' => $a->getTeljesNev(),
        'ar'  => $a->getAr(),
        'kep' => $a->getKep(),
    ];
}

$extrak = [
    'gyerekules' => ['nev' => 'Gyerekülés',    'ar' => 2000, 'ikon' => 'fa-baby'],
];

$pageTitle = 'Foglalás';
$pageCss = 'kolcsonzes.css';
include __DIR__ . '/../includes/header.php';
?>

<section class="page-banner">
    <h1>Autó foglalása</h1>
</section>

<main class="page">
    <form method="post" class="booking-layout">

        <div class="booking-form">

            <section class="form-section">
                <h2><span class="step">1</span> Autó és időpont</h2>

                <label>Autó
                    <select name="auto_id" id="auto" required>
                        <option value="">Válassz autót…</option>
                        <?php foreach ($autok as $a): ?>
                            <option value="<?= e($a->getId()) ?>" <?= $a->getId() === $valasztottId ? 'selected' : '' ?>>
                                <?= e($a->getTeljesNev()) ?> – <?= number_format($a->getAr(), 0, ',', ' ') ?> Ft/nap
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <div class="form-row">
                    <label>Átvétel
                        <input type="date" id="atvetel" name="atvetel" value="<?= e($atvetel) ?>" min="<?= $ma ?>" required>
                    </label>
                    <label>Leadás
                        <input type="date" id="leadas" name="leadas" value="<?= e($leadas) ?>" min="<?= $ma ?>" required>
                    </label>
                </div>

                <label>Átvételi hely
                    <select name="hely" required>
                        <option value="belvaros">Budapest – Belváros</option>
                        <option value="repuloter">Budapest – Liszt Ferenc repülőtér</option>
                        <option value="gyor">Győr</option>
                    </select>
                </label>
            </section>

            <section class="form-section">
                <h2><span class="step">2</span> Extrák</h2>
                <div class="extras">
                    <?php foreach ($extrak as $kulcs => $extra): ?>
                        <label class="extra">
                            <input type="checkbox" name="extrak[]" value="<?= e($kulcs) ?>" data-ar="<?= e($extra['ar']) ?>">
                            <i class="fa-solid <?= e($extra['ikon']) ?>"></i>
                            <span class="extra-name"><?= e($extra['nev']) ?></span>
                            <span class="extra-price">+<?= number_format($extra['ar'], 0, ',', ' ') ?> Ft/nap</span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="form-section">
                <h2><span class="step">3</span> Személyes adatok</h2>
                <div class="form-row">
                    <label>Teljes név
                        <input type="text" name="nev" value="<?= e($_SESSION['name'] ?? '') ?>" required>
                    </label>
                    <label>Születési dátum
                        <input type="date" name="szuletesi_datum" max="<?= $legkesobbiSzuletes ?>" required>
                        <small>Legalább 21 évesnek kell lenned.</small>
                    </label>
                </div>
                <div class="form-row">
                    <label>Telefonszám
                        <input type="tel" name="telefon" placeholder="+36 30 123 4567" required>
                    </label>
                    <label>E-mail
                        <input type="email" name="email" required>
                    </label>
                </div>
                <div class="form-row form-row-3">
                    <label>Irányítószám
                        <input type="text" name="iranyitoszam" pattern="[0-9]{4}" maxlength="4"
                               placeholder="1234" title="4 számjegy" required>
                    </label>
                    <label>Település
                        <input type="text" name="telepules" required>
                    </label>
                    <label>Utca, házszám
                        <input type="text" name="cim" required>
                    </label>
                </div>
            </section>

            <section class="form-section">
                <h2><span class="step">4</span> Okmányok</h2>
                <div class="form-row">
                    <label>Személyi igazolvány / útlevél száma
                        <input type="text" name="szemelyi_szam" placeholder="123456AB"
                               pattern="[A-Za-z0-9]{6,9}" title="6–9 karakter, csak betű és szám" required>
                    </label>
                    <label>Jogosítvány száma
                        <input type="text" name="jogsi_szam" placeholder="AB123456"
                               pattern="[A-Za-z0-9]{6,9}" title="6–9 karakter, csak betű és szám" required>
                    </label>
                </div>
                <div class="form-row">
                    <label>Jogosítvány kiállításának dátuma
                        <input type="date" name="jogsi_kiallitas" max="<?= $legkesobbiJogsi ?>" required>
                        <small>Legalább 1 éve meglévő jogosítvány szükséges.</small>
                    </label>
                    <label>Jogosítvány lejárata
                        <input type="date" name="jogsi_lejarat" min="<?= $ma ?>" required>
                    </label>
                </div>

                <label>Megjegyzés
                    <textarea name="megjegyzes" rows="3" placeholder="Pl. várható érkezési idő, egyéb kérés"></textarea>
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="aszf" required>
                    Elfogadom a bérlési feltételeket és az adatkezelési tájékoztatót
                </label>
            </section>
        </div>


        <aside class="booking-summary">
            <h2>Összesítő</h2>
            <img id="osszesito-kep" src="" alt="" hidden>
            <p class="summary-car" id="osszesito-auto">Még nincs autó kiválasztva</p>

            <dl class="summary-list">
                <dt>Napok száma</dt>  <dd id="osszesito-napok">–</dd>
                <dt>Bérleti díj</dt>  <dd id="osszesito-berles">–</dd>
                <dt>Extrák</dt>       <dd id="osszesito-extrak">–</dd>
            </dl>

            <div class="summary-total">
                <span>Összesen</span>
                <strong id="osszesito-osszeg">–</strong>
            </div>

            <button type="submit" class="btn-accent-full">Foglalás véglegesítése</button>
        </aside>
    </form>
</main>

<script>

    const AUTOK = <?= json_encode($autokJs, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;
</script>
<script src="/Kolcsonzo/assets/js/kolcsonzes.js"></script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
