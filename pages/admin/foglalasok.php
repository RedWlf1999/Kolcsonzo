<?php
require __DIR__ . '/../../includes/auth.php';
onlyAdmin();

require __DIR__ . '/../../models/booking.php';

$uzenet = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['muvelet'])) {
    $muveletNeve = $_POST['muvelet'] === 'jovahagyas' ? 'jóváhagyás' : 'elutasítás';
    $uzenet = 'Ez tesztadat, a ' . $muveletNeve;
}

$osszesFoglalas = Booking::osszes();

$statuszok = [
    ''            => 'Összes',
    'fuggoben'    => 'Függőben',
    'jovahagyva'  => 'Jóváhagyva',
    'folyamatban' => 'Folyamatban',
    'lezarva'     => 'Lezárva',
    'lemondva'    => 'Lemondva',
];
$darab = ['' => count($osszesFoglalas)];
foreach ($osszesFoglalas as $f) {
    $darab[$f->getStatusz()] = ($darab[$f->getStatusz()] ?? 0) + 1;
}


$valasztott = $_GET['statusz'] ?? '';
$foglalasok = [];
foreach ($osszesFoglalas as $f) {
    if ($valasztott === '' || $f->getStatusz() === $valasztott) {
        $foglalasok[] = $f;
    }
}


usort($foglalasok, function ($a, $b) {
    return strcmp($a->getAtvetel(), $b->getAtvetel());
});

$pageTitle = 'Foglalások kezelése';
$pageCss = 'admin.css';
include __DIR__ . '/../../includes/header.php';
?>

<main class="page">
    <div class="admin-head">
        <div>
            <h1>Foglalások kezelése</h1>
            <p><?= count($foglalasok) ?> foglalás</p>
        </div>
    </div>

    <?php if ($uzenet !== ''): ?>
        <p class="notice"><i class="fa-solid fa-circle-info"></i> <?= e($uzenet) ?></p>
    <?php endif; ?>

    <nav class="status-tabs">
        <?php foreach ($statuszok as $kulcs => $nev): ?>
            <a href="?statusz=<?= e($kulcs) ?>" class="<?= $kulcs === $valasztott ? 'active' : '' ?>">
                <?= e($nev) ?> <span class="count"><?= $darab[$kulcs] ?? 0 ?></span>
            </a>
        <?php endforeach; ?>
    </nav>

    <section class="panel">
        <?php if (count($foglalasok) === 0): ?>
            <p class="empty">Nincs ilyen státuszú foglalás.</p>
        <?php else: ?>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ügyfél</th>
                            <th>Autó</th>
                            <th>Időszak</th>
                            <th>Átvételi hely</th>
                            <th>Összeg</th>
                            <th>Státusz</th>
                            <th class="col-actions">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($foglalasok as $f): ?>
                            <?php $auto = $f->getAuto(); ?>
                            <tr class="row-link" onclick="location.href='foglalas.php?id=<?= e($f->getId()) ?>'">
                                <td><?= e($f->getId()) ?></td>
                                <td>
                                    <strong><?= e($f->getNev()) ?></strong>
                                    <span class="sub"><?= e($f->getEmail()) ?></span>
                                </td>
                                <td><?= $auto ? e($auto->getTeljesNev()) : '–' ?></td>
                                <td>
                                    <?= e(Booking::datum($f->getAtvetel())) ?> – <?= e(Booking::datum($f->getLeadas())) ?>
                                    <span class="sub"><?= e($f->getNapok()) ?> nap</span>
                                </td>
                                <td><?= e($f->getHelyNev()) ?></td>
                                <td><?= number_format($f->getOsszeg(), 0, ',', ' ') ?> Ft</td>
                                <td><span class="badge badge-<?= e($f->getStatusz()) ?>"><?= e($f->getStatuszNev()) ?></span></td>
                                <td class="col-actions">
                                    <?php if ($f->getStatusz() === 'fuggoben'): ?>
                                        <form method="post" class="inline-form" onclick="event.stopPropagation();">
                                            <input type="hidden" name="foglalas_id" value="<?= e($f->getId()) ?>">
                                            <button type="submit" name="muvelet" value="jovahagyas" class="btn-sm btn-success">
                                                <i class="fa-solid fa-check"></i> Jóváhagyás
                                            </button>
                                            <button type="submit" name="muvelet" value="elutasitas" class="btn-sm btn-danger"
                                                    onclick="return confirm('Biztosan elutasítod ezt a foglalást?');">
                                                <i class="fa-solid fa-xmark"></i> Elutasítás
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="sub">–</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
