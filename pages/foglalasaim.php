<?php
require __DIR__ . '/../includes/auth.php';
onlyLogon();

require __DIR__ . '/../models/booking.php';

$uzenet = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lemondas_id'])) {
    $uzenet = 'Ez ál-adat, a lemondás még nem mentődik el.';
}

$ma = date('Y-m-d');
$foglalasok = Booking::felhasznaloFoglalasai($_SESSION['name'] ?? '');

$kozelgok = [];
$korabbiak = [];
foreach ($foglalasok as $f) {
    $aktiv = in_array($f->getStatusz(), ['fuggoben', 'jovahagyva', 'folyamatban']);
    if ($aktiv && $f->getLeadas() >= $ma) {
        $kozelgok[] = $f;
    } else {
        $korabbiak[] = $f;
    }
}

usort($kozelgok, function ($a, $b) { return strcmp($a->getAtvetel(), $b->getAtvetel()); });
usort($korabbiak, function ($a, $b) { return strcmp($b->getAtvetel(), $a->getAtvetel()); });

$csoportok = [
    'Közelgő foglalások' => $kozelgok,
    'Korábbi foglalások' => $korabbiak,
];

$pageTitle = 'Foglalásaim';
$pageCss = 'foglalasaim.css';
include __DIR__ . '/../includes/header.php';
?>

<main class="page">
    <div class="my-head">
        <h1>Foglalásaim</h1>
        <a href="jarmuvek.php" class="btn-primary"><i class="fa-solid fa-plus"></i> Új foglalás</a>
    </div>

    <?php if ($uzenet !== ''): ?>
        <p class="notice"><i class="fa-solid fa-circle-info"></i> <?= e($uzenet) ?></p>
    <?php endif; ?>

    <?php if (count($foglalasok) === 0): ?>
        <div class="empty-state">
            <i class="fa-solid fa-calendar-xmark"></i>
            <h2>Még nincs foglalásod</h2>
            <p>Nézz körül az autóink között, és foglalj pár kattintással.</p>
            <a href="jarmuvek.php" class="btn-primary">Autók megtekintése</a>
        </div>
    <?php else: ?>
        <?php foreach ($csoportok as $cim => $lista): ?>
            <?php if (count($lista) > 0): ?>
                <h2 class="group-title"><?= e($cim) ?></h2>
                <div class="booking-list">
                    <?php foreach ($lista as $f): ?>
                        <?php $auto = $f->getAuto(); ?>
                        <article class="booking-item">
                            <img src="/Kolcsonzo/assets/pics/cars/<?= e($auto ? $auto->getKep() : '') ?>" alt="">

                            <div class="booking-info">
                                <div class="booking-title">
                                    <h3><?= $auto ? e($auto->getTeljesNev()) : 'Ismeretlen autó' ?></h3>
                                    <span class="badge badge-<?= e($f->getStatusz()) ?>"><?= e($f->getStatuszNev()) ?></span>
                                </div>
                                <ul class="booking-meta">
                                    <li><i class="fa-solid fa-calendar"></i>
                                        <?= e(Booking::datum($f->getAtvetel())) ?> – <?= e(Booking::datum($f->getLeadas())) ?>
                                        (<?= e($f->getNapok()) ?> nap)</li>
                                    <li><i class="fa-solid fa-location-dot"></i> <?= e($f->getHelyNev()) ?></li>
                                    <li><i class="fa-solid fa-hashtag"></i> Foglalásszám: <?= e($f->getId()) ?></li>
                                </ul>
                            </div>

                            <div class="booking-side">
                                <strong><?= number_format($f->getOsszeg(), 0, ',', ' ') ?> Ft</strong>
                                <?php if (in_array($f->getStatusz(), ['fuggoben', 'jovahagyva']) && $f->getAtvetel() > $ma): ?>
                                    <form method="post" onsubmit="return confirm('Biztosan lemondod ezt a foglalást?');">
                                        <input type="hidden" name="lemondas_id" value="<?= e($f->getId()) ?>">
                                        <button type="submit" class="btn-cancel">Lemondás</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
