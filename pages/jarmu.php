<?php
require __DIR__ . '/../models/car.php';

$id = (int) ($_GET['id'] ?? 0);
$auto = Car::keres($id);

$atvetel = $_GET['atvetel'] ?? '';
$leadas  = $_GET['leadas'] ?? '';

$pageTitle = $auto ? $auto->getTeljesNev() : 'Autó nem található';
$pageCss = 'jarmu.css';
include __DIR__ . '/../includes/header.php';
?>

<main class="page">
    <a href="jarmuvek.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Vissza az autókhoz</a>

    <?php if (!$auto): ?>
        <div class="not-found">
            <i class="fa-solid fa-car-burst"></i>
            <h1>Ez az autó nem található</h1>
            <a href="jarmuvek.php" class="btn-primary">Vissza a listához</a>
        </div>
    <?php else: ?>
        <div class="car-detail">


            <div class="car-detail-main">
                <div class="car-detail-image">
                    <img src="/Kolcsonzo/assets/pics/cars/<?= e($auto->getKep()) ?>" alt="<?= e($auto->getTeljesNev()) ?>">
                </div>

                <p class="car-category"><?= e($auto->getKategoria()) ?></p>
                <h1><?= e($auto->getTeljesNev()) ?> <span class="car-year"><?= e($auto->getEv()) ?></span></h1>

                <h2>Tulajdonságok</h2>
                <div class="spec-grid">
                    <div class="spec">
                        <i class="fa-solid fa-user-group"></i>
                        <span class="spec-label">Ülések</span>
                        <strong><?= e($auto->getUlesek()) ?> fő</strong>
                    </div>
                    <div class="spec">
                        <i class="fa-solid fa-suitcase"></i>
                        <span class="spec-label">Csomagtér</span>
                        <strong><?= e($auto->getCsomagter()) ?> l</strong>
                    </div>
                    <div class="spec">
                        <i class="fa-solid fa-gears"></i>
                        <span class="spec-label">Váltó</span>
                        <strong><?= e($auto->getValto()) ?></strong>
                    </div>
                    <div class="spec">
                        <i class="fa-solid fa-gas-pump"></i>
                        <span class="spec-label">Üzemanyag</span>
                        <strong><?= e($auto->getUzemanyag()) ?></strong>
                    </div>
                    <div class="spec">
                        <i class="fa-solid fa-leaf"></i>
                        <span class="spec-label">Fogyasztás</span>
                        <strong><?= e($auto->getFogyasztas()) ?></strong>
                    </div>
                    <div class="spec">
                        <i class="fa-solid fa-calendar"></i>
                        <span class="spec-label">Évjárat</span>
                        <strong><?= e($auto->getEv()) ?></strong>
                    </div>
                </div>

                <h2>Leírás</h2>
                <p class="car-description"><?= e($auto->getLeiras()) ?></p>
            </div>

            <aside class="booking-card" data-ar="<?= e($auto->getAr()) ?>">
                <p class="booking-price">
                    <strong><?= number_format($auto->getAr(), 0, ',', ' ') ?> Ft</strong> / nap
                </p>


                <form method="get" action="kolcsonzes.php">
                    <input type="hidden" name="auto_id" value="<?= e($auto->getId()) ?>">

                    <label>Átvétel
                        <input type="date" id="atvetel" name="atvetel" value="<?= e($atvetel) ?>" min="<?= date('Y-m-d') ?>">
                    </label>
                    <label>Leadás
                        <input type="date" id="leadas" name="leadas" value="<?= e($leadas) ?>" min="<?= date('Y-m-d') ?>">
                    </label>

                    <div class="booking-total">
                        <span>Összesen</span>
                        <strong id="osszeg">–</strong>
                    </div>

                    <button type="submit" class="btn-accent-full">Foglalás</button>
                </form>

                <?php if (!$szerepKor): ?>
                    <p class="booking-register">A foglaláshoz be kell jelentkezned.</p>
                <?php endif; ?>
            </aside>

        </div>
        
        <script src="/Kolcsonzo/assets/js/jarmu.js"></script>

    <?php endif; ?>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
