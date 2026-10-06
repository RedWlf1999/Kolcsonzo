<?php
$pageTitle = 'Főoldal';
$pageCss = 'index.css';
include __DIR__ . '/includes/header.php';
?>

<main class="page">

    <section class="hero">
        <h1>Bérelj autót egyszerűen</h1>
        <p>Válaszd ki az autót, foglald le pár kattintással, és már indulhatsz is.</p>
        <div class="hero-buttons">
            <a href="/Kolcsonzo/pages/kolcsonzes.php" class="btn-primary">Foglalás indítása</a>
            <a href="/Kolcsonzo/pages/jarmuvek.php" class="btn-secondary">Autók megtekintése</a>
        </div>
    </section>

    <section class="steps">
        <h2>Hogyan működik?</h2>
        <div class="steps-grid">
            <div class="step">
                <img src="/Kolcsonzo/assets/pics/home/1_lepes.svg" alt="">
                <span class="step-number">1</span>
                <h3>Válassz autót</h3>
                <p>Böngészd az autóinkat, és válaszd ki, ami neked kell.</p>
            </div>
            <div class="step">
                <img src="/Kolcsonzo/assets/pics/home/2_lepes.svg" alt="">
                <span class="step-number">2</span>
                <h3>Foglald le</h3>
                <p>Add meg a dátumokat, és foglalj pár kattintással.</p>
            </div>
            <div class="step">
                <img src="/Kolcsonzo/assets/pics/home/3_lepes.svg" alt="">
                <span class="step-number">3</span>
                <h3>Vedd át</h3>
                <p>A megadott napon átveheted az autót az irodánkban.</p>
            </div>
            <div class="step">
                <img src="/Kolcsonzo/assets/pics/home/4_lepes.svg" alt="">
                <span class="step-number">4</span>
                <h3>Indulhat az utazás</h3>
                <p>Ülj be, és élvezd az utat!</p>
            </div>
        </div>
    </section>

    <section class="features">
        <h2>Miért minket válassz?</h2>
        <div class="features-grid">
            <div class="feature">
                <img src="/Kolcsonzo/assets/pics/home/calendar.png" alt="">
                <div>
                    <h3>Rugalmas kölcsönzés</h3>
                    <p>A foglalásodat az átvétel előtt bármikor módosíthatod vagy lemondhatod.</p>
                </div>
            </div>
            <div class="feature">
                <img src="/Kolcsonzo/assets/pics/home/money.png" alt="">
                <div>
                    <h3>Nincsenek rejtett költségek</h3>
                    <p>Foglaláskor pontosan látod, mennyit fogsz fizetni.</p>
                </div>
            </div>
            <div class="feature">
                <img src="/Kolcsonzo/assets/pics/home/fast.png" alt="">
                <div>
                    <h3>Gyors online foglalás</h3>
                    <p>Néhány perc az egész, sorban állás és papírmunka nélkül.</p>
                </div>
            </div>
            <div class="feature">
                <img src="/Kolcsonzo/assets/pics/home/safe.png" alt="">
                <div>
                    <h3>Megbízható autók</h3>
                    <p>Minden autónk rendszeresen szervizelt és tiszta.</p>
                </div>
            </div>
        </div>
    </section>

</main>

<?php include __DIR__ . '/includes/footer.php'; ?>