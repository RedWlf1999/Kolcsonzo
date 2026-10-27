<?php
require __DIR__ . '/../../includes/auth.php';
onlyAdmin();

require __DIR__ . '/../../models/booking.php';

$id = (int) ($_GET['id'] ?? 0);
$foglalas = Booking::keres($id);
$auto = $foglalas ? $foglalas->getAuto() : null;


$uzenet = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['muvelet'])) {
    $muveletNeve = $_POST['muvelet'] === 'jovahagyas' ? 'jóváhagyás' : 'elutasítás';
    $uzenet = 'Ez teszt-adat, a ' . $muveletNeve;
}

$pageTitle = $foglalas ? 'Foglalás #' . $foglalas->getId() : 'Foglalás nem található';
$pageCss = 'admin.css';
include __DIR__ . '/../../includes/header.php';
?>

<main class="page">
    <a href="foglalasok.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Vissza a foglalásokhoz</a>

    <?php if (!$foglalas): ?>
        <p class="empty">Ez a foglalás nem található.</p>
    <?php else: ?>
        <div class="admin-head">
            <div>
                <h1>Foglalás #<?= e($foglalas->getId()) ?></h1>
                <p>Létrehozva: <?= e(Booking::datum($foglalas->getLetrehozva())) ?></p>
            </div>
            <span class="badge badge-lg badge-<?= e($foglalas->getStatusz()) ?>"><?= e($foglalas->getStatuszNev()) ?></span>
        </div>

        <?php if ($uzenet !== ''): ?>
            <p class="notice"><i class="fa-solid fa-circle-info"></i> <?= e($uzenet) ?></p>
        <?php endif; ?>

        <div class="detail-grid">
            <section class="panel">
                <h2 class="panel-title">Autó</h2>
                <?php if ($auto): ?>
                    <img class="detail-car-img" src="/Kolcsonzo/assets/pics/cars/<?= e($auto->getKep()) ?>" alt="">
                    <p class="detail-car-name"><?= e($auto->getTeljesNev()) ?></p>
                    <p class="sub"><?= e($auto->getKategoria()) ?> · <?= e($auto->getValto()) ?> · <?= e($auto->getUzemanyag()) ?></p>
                    <a href="jarmu-szerkesztes.php?id=<?= e($auto->getId()) ?>" class="btn-sm">
                        <i class="fa-solid fa-pen"></i> Autó szerkesztése
                    </a>
                <?php else: ?>
                    <p class="sub">Az autó már nem található.</p>
                <?php endif; ?>
            </section>

            <section class="panel">
                <h2 class="panel-title">Foglalás adatai</h2>
                <dl class="detail-list">
                    <dt>Átvétel</dt>
                    <dd><?= e(Booking::datum($foglalas->getAtvetel())) ?></dd>
                    <dt>Leadás</dt>
                    <dd><?= e(Booking::datum($foglalas->getLeadas())) ?></dd>
                    <dt>Időtartam</dt>
                    <dd><?= e($foglalas->getNapok()) ?> nap</dd>
                    <dt>Átvételi hely</dt>
                    <dd><?= e($foglalas->getHelyNev()) ?></dd>
                    <dt>Napi díj</dt>
                    <dd><?= $auto ? number_format($auto->getAr(), 0, ',', ' ') . ' Ft' : '–' ?></dd>
                    <dt class="detail-total">Összesen</dt>
                    <dd class="detail-total"><?= number_format($foglalas->getOsszeg(), 0, ',', ' ') ?> Ft</dd>
                </dl>
            </section>

            <section class="panel">
                <h2 class="panel-title">Ügyfél</h2>
                <dl class="detail-list">
                    <dt>Név</dt>
                    <dd><?= e($foglalas->getNev()) ?></dd>
                    <dt>E-mail</dt>
                    <dd><a href="mailto:<?= e($foglalas->getEmail()) ?>"><?= e($foglalas->getEmail()) ?></a></dd>
                </dl>

                <?php if ($foglalas->getStatusz() === 'fuggoben'): ?>
                    <form method="post" class="detail-actions">
                        <button type="submit" name="muvelet" value="jovahagyas" class="btn-sm btn-success">
                            <i class="fa-solid fa-check"></i> Jóváhagyás
                        </button>
                        <button type="submit" name="muvelet" value="elutasitas" class="btn-sm btn-danger"
                                onclick="return confirm('Biztosan elutasítod ezt a foglalást?');">
                            <i class="fa-solid fa-xmark"></i> Elutasítás
                        </button>
                    </form>
                <?php endif; ?>
            </section>
        </div>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
