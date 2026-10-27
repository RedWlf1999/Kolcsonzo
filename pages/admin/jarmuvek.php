<?php
require __DIR__ . '/../../includes/auth.php';
onlyAdmin();

require __DIR__ . '/../../models/car.php';

$uzenet = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['torles_id'])) {
    $uzenet = 'Ez ál-adat, a törlés még nem mentődik el.';
}

$kereses = trim($_GET['kereses'] ?? '');
$autok = [];
foreach (Car::osszes() as $auto) {
    if ($kereses === '' || mb_stripos($auto->getTeljesNev(), $kereses) !== false) {
        $autok[] = $auto;
    }
}

$pageTitle = 'Járművek kezelése';
$pageCss = 'admin.css';
include __DIR__ . '/../../includes/header.php';
?>

<main class="page">
    <div class="admin-head">
        <div>
            <h1>Járművek kezelése</h1>
            <p><?= count($autok) ?> autó</p>
        </div>
        <a href="jarmu-szerkesztes.php" class="btn-primary"><i class="fa-solid fa-plus"></i> Új autó</a>
    </div>

    <?php if ($uzenet !== ''): ?>
        <p class="notice"><i class="fa-solid fa-circle-info"></i> <?= e($uzenet) ?></p>
    <?php endif; ?>

    <section class="panel">
        <form method="get" class="toolbar">
            <input type="text" name="kereses" value="<?= e($kereses) ?>" placeholder="Keresés márka vagy típus szerint">
            <button type="submit" class="btn-secondary">Keresés</button>
        </form>

        <?php if (count($autok) === 0): ?>
            <p class="empty">Nincs a keresésnek megfelelő autó.</p>
        <?php else: ?>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Autó</th>
                            <th>Ár / nap</th>
                            <th>Váltó</th>
                            <th>Üzemanyag</th>
                            <th>Évjárat</th>
                            <th class="col-actions">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($autok as $auto): ?>
                            <tr>
                                <td>
                                    <img class="thumb" src="/Kolcsonzo/assets/pics/cars/<?= e($auto->getKep()) ?>" alt="">
                                </td>
                                <td>
                                    <strong><?= e($auto->getTeljesNev()) ?></strong>
                                    <span class="sub"><?= e($auto->getKategoria()) ?></span>
                                </td>
                                <td><?= number_format($auto->getAr(), 0, ',', ' ') ?> Ft</td>
                                <td><?= e($auto->getValto()) ?></td>
                                <td><?= e($auto->getUzemanyag()) ?></td>
                                <td><?= e($auto->getEv()) ?></td>
                                <td class="col-actions">
                                    <a href="jarmu-szerkesztes.php?id=<?= e($auto->getId()) ?>" class="btn-sm">
                                        <i class="fa-solid fa-pen"></i> Szerkesztés
                                    </a>
                                    <form method="post" class="inline-form"
                                          onsubmit="return confirm(<?= e(json_encode('Biztosan törlöd: ' . $auto->getTeljesNev() . '?', JSON_UNESCAPED_UNICODE)) ?>);">
                                        <input type="hidden" name="torles_id" value="<?= e($auto->getId()) ?>">
                                        <button type="submit" class="btn-sm btn-danger">
                                            <i class="fa-solid fa-trash"></i> Törlés
                                        </button>
                                    </form>
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
