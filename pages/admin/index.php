<?php
require __DIR__ . '/../../includes/auth.php';
onlyAdmin();

require __DIR__ . '/../../models/car.php';
require __DIR__ . '/../../models/booking.php';

$autok = Car::osszes();
$foglalasok = Booking::osszes();

$kiadva = 0;
$fuggoben = 0;
$haviBevetel = 0;
$aktualisHonap = date('Y-m');

foreach ($foglalasok as $f) {
    if ($f->getStatusz() === 'folyamatban') {
        $kiadva++;
    }
    if ($f->getStatusz() === 'fuggoben') {
        $fuggoben++;
    }
    if ($f->getStatusz() !== 'lemondva' && substr($f->getAtvetel(), 0, 7) === $aktualisHonap) {
        $haviBevetel += $f->getOsszeg();
    }
}

usort($foglalasok, function ($a, $b) {
    return strcmp($b->getLetrehozva(), $a->getLetrehozva());
});
$legutobbiak = array_slice($foglalasok, 0, 5);

$pageTitle = 'Áttekintés';
$pageCss = 'admin.css';
include __DIR__ . '/../../includes/header.php';
?>

<main class="page">
    <div class="admin-head">
        <div>
            <h1>Áttekintés</h1>
            <p>Üdv, <?= e($_SESSION['name'] ?? 'Admin') ?>! Itt látod a kölcsönző aktuális állapotát.</p>
        </div>
    </div>

    <div class="stats">
        <div class="stat">
            <span class="stat-icon"><i class="fa-solid fa-car"></i></span>
            <div>
                <strong><?= count($autok) ?></strong>
                <span>Autó a flottában</span>
            </div>
        </div>
        <div class="stat">
            <span class="stat-icon stat-green"><i class="fa-solid fa-road"></i></span>
            <div>
                <strong><?= $kiadva ?></strong>
                <span>Jelenleg kiadva</span>
            </div>
        </div>
        <a href="foglalasok.php?statusz=fuggoben" class="stat">
            <span class="stat-icon stat-amber"><i class="fa-solid fa-hourglass-half"></i></span>
            <div>
                <strong><?= $fuggoben ?></strong>
                <span>Függő foglalás</span>
            </div>
        </a>
        <div class="stat">
            <span class="stat-icon stat-blue"><i class="fa-solid fa-coins"></i></span>
            <div>
                <strong><?= number_format($haviBevetel, 0, ',', ' ') ?> Ft</strong>
                <span>E havi bevétel</span>
            </div>
        </div>
    </div>

    <section class="panel">
        <div class="panel-head">
            <h2>Legutóbbi foglalások</h2>
            <a href="foglalasok.php">Összes foglalás <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ügyfél</th>
                        <th>Autó</th>
                        <th>Időszak</th>
                        <th>Összeg</th>
                        <th>Státusz</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($legutobbiak as $f): ?>
                        <?php $auto = $f->getAuto(); ?>
                        <tr class="row-link" onclick="location.href='foglalas.php?id=<?= e($f->getId()) ?>'">
                            <td><?= e($f->getId()) ?></td>
                            <td><?= e($f->getNev()) ?></td>
                            <td><?= $auto ? e($auto->getTeljesNev()) : '–' ?></td>
                            <td><?= e(Booking::datum($f->getAtvetel())) ?> – <?= e(Booking::datum($f->getLeadas())) ?></td>
                            <td><?= number_format($f->getOsszeg(), 0, ',', ' ') ?> Ft</td>
                            <td><span class="badge badge-<?= e($f->getStatusz()) ?>"><?= e($f->getStatuszNev()) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
