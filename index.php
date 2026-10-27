<?php
require __DIR__ . '/models/car.php';


$kategoriak = [];
foreach (Car::osszes() as $auto) {
    $kategoriak[] = $auto->getKategoria();
}
$kategoriak = array_unique($kategoriak);
sort($kategoriak);

$ma = date('Y-m-d');

$pageTitle = 'Főoldal';
$pageCss = 'index.css';
include __DIR__ . '/includes/header.php';
?>


<section class="hero">
    <div class="hero-inner">
        <h1>Bérelj autót egyszerűen</h1>
        <p>Válaszd ki az autót, foglald le pár kattintással, és már indulhatsz is.</p>

        <form class="search-box" method="get" action="/Kolcsonzo/pages/jarmuvek.php">
            <label>Átvétel
                <input type="date" name="atvetel" min="<?= $ma ?>">
            </label>
            <label>Leadás
                <input type="date" name="leadas" min="<?= $ma ?>">
            </label>
            <label>Kategória
                <select name="kategoria">
                    <option value="">Mind</option>
                    <?php foreach ($kategoriak as $k): ?>
                        <option value="<?= e($k) ?>"><?= e($k) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i> Autók keresése
            </button>
        </form>

        <div class="hero-links">
            <a href="/Kolcsonzo/pages/jarmuvek.php">Autók megtekintése <i class="fa-solid fa-arrow-right"></i></a>
            <a href="/Kolcsonzo/pages/kolcsonzes.php">Foglalás indítása <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<section class="usp-bar" aria-label="Miért minket válassz?">
    <div class="usp">
        <img src="/Kolcsonzo/assets/pics/home/calendar.png" alt="">
        <div>
            <h3>Rugalmas kölcsönzés</h3>
            <p>A foglalásodat az átvétel előtt bármikor módosíthatod vagy lemondhatod.</p>
        </div>
    </div>
    <div class="usp">
        <img src="/Kolcsonzo/assets/pics/home/money.png" alt="">
        <div>
            <h3>Nincsenek rejtett költségek</h3>
            <p>Foglaláskor pontosan látod, mennyit fogsz fizetni.</p>
        </div>
    </div>
    <div class="usp">
        <img src="/Kolcsonzo/assets/pics/home/fast.png" alt="">
        <div>
            <h3>Gyors online foglalás</h3>
            <p>Néhány perc az egész, sorban állás és papírmunka nélkül.</p>
        </div>
    </div>
    <div class="usp">
        <img src="/Kolcsonzo/assets/pics/home/safe.png" alt="">
        <div>
            <h3>Megbízható autók</h3>
            <p>Minden autónk rendszeresen szervizelt és tiszta.</p>
        </div>
    </div>
</section>

<main class="page">
    <section class="steps">
        <h2 class="section-title">Hogyan működik?</h2>
        <div class="steps-grid">
            <div class="step">
                <span class="step-number">01</span>
                <img src="/Kolcsonzo/assets/pics/home/1_lepes.svg" alt="">
                <h3>Válassz autót</h3>
                <p>Böngészd az autóinkat, és válaszd ki, ami neked kell.</p>
            </div>
            <div class="step">
                <span class="step-number">02</span>
                <img src="/Kolcsonzo/assets/pics/home/2_lepes.svg" alt="">
                <h3>Foglald le</h3>
                <p>Add meg a dátumokat, és foglalj pár kattintással.</p>
            </div>
            <div class="step">
                <span class="step-number">03</span>
                <img src="/Kolcsonzo/assets/pics/home/3_lepes.svg" alt="">
                <h3>Vedd át</h3>
                <p>A megadott napon átveheted az autót az irodánkban.</p>
            </div>
            <div class="step">
                <span class="step-number">04</span>
                <img src="/Kolcsonzo/assets/pics/home/4_lepes.svg" alt="">
                <h3>Indulhat az utazás</h3>
                <p>Ülj be, és élvezd az utat!</p>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
