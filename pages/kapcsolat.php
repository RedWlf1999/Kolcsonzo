<?php
$elerhetosegek = [
    ['ikon' => 'fa-phone',        'cim' => 'Telefon',         'ertek' => '+36 1 234 5678',        'link' => 'tel:+3612345678',             'megj' => 'Nyitvatartási időben'],
    ['ikon' => 'fa-envelope',     'cim' => 'E-mail',          'ertek' => 'info@autokolcsonzo.hu', 'link' => 'mailto:info@autokolcsonzo.hu', 'megj' => 'Egy munkanapon belül válaszolunk'],
    ['ikon' => 'fa-location-dot', 'cim' => 'Központi iroda',  'ertek' => '1051 Budapest, Példa utca 1.', 'link' => '',               'megj' => 'Hétfő–Péntek: 8:00–18:00'],
];

$helyszinek = [
    ['nev' => 'Budapest – Belváros',              'cim' => '1051 Budapest, Példa utca 1.',        'nyitva' => 'H–P 8:00–18:00, Szo 9:00–13:00'],
    ['nev' => 'Budapest – Liszt Ferenc repülőtér', 'cim' => '1185 Budapest, Repülőtéri út, 2. terminál', 'nyitva' => 'Minden nap 6:00–22:00'],
    ['nev' => 'Győr',                              'cim' => '9021 Győr, Minta tér 5.',             'nyitva' => 'H–P 8:00–17:00'],
];

$gyik = [
    'Hány éves kortól bérelhetek autót?' =>
        'Legalább 21 évesnek kell lenned, és legalább 1 éve rendelkezned kell érvényes B kategóriás jogosítvánnyal.',
    'Milyen okmányokat kell vinnem az átvételhez?' =>
        'Személyi igazolványt vagy útlevelet, valamint a jogosítványodat. Az okmányok számát a foglaláskor is meg kell adnod.',
    'Hogyan tudom lemondani a foglalásomat?' =>
        'A Foglalásaim oldalon a függőben lévő vagy jóváhagyott foglalások mellett találsz egy Lemondás gombot. Átvétel napja előtt díjmentesen lemondhatod.',
    'Mennyi üzemanyaggal kapom meg az autót?' =>
        'Az autókat teli tankkal adjuk át, és teli tankkal kérjük vissza. Ha ez nem sikerül, a hiányzó üzemanyagot felszámoljuk.',
    'Kérhetek gyerekülést?' =>
        'Igen, foglaláskor az Extrák között tudod kiválasztani, napi 2 000 Ft-ért.',
    'Hogyan fizethetek?' =>
        'Az autó átvételekor bankkártyával vagy készpénzzel fizethetsz.',
];

$pageTitle = 'Kapcsolat';
$pageCss = 'kapcsolat.css';
include __DIR__ . '/../includes/header.php';
?>

<section class="page-banner">
    <h1>Kapcsolat</h1>
</section>

<main class="page">
    <p class="contact-intro">Kérdésed van a foglalással vagy az autókkal kapcsolatban? Hívj minket, írj e-mailt, vagy nézd meg a gyakori kérdéseket lent.</p>

    <div class="contact-cards">
        <?php foreach ($elerhetosegek as $el): ?>
            <div class="contact-card">
                <i class="fa-solid <?= e($el['ikon']) ?>"></i>
                <h2><?= e($el['cim']) ?></h2>
                <?php if ($el['link'] !== ''): ?>
                    <a href="<?= e($el['link']) ?>"><?= e($el['ertek']) ?></a>
                <?php else: ?>
                    <strong><?= e($el['ertek']) ?></strong>
                <?php endif; ?>
                <span><?= e($el['megj']) ?></span>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="contact-layout">
        <section>
            <h2 class="section-heading">Átvételi pontjaink</h2>
            <ul class="location-list">
                <?php foreach ($helyszinek as $h): ?>
                    <li>
                        <h3><?= e($h['nev']) ?></h3>
                        <p><i class="fa-solid fa-location-dot"></i> <?= e($h['cim']) ?></p>
                        <p><i class="fa-solid fa-clock"></i> <?= e($h['nyitva']) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section>
            <h2 class="section-heading">Gyakori kérdések</h2>
            <div class="faq">
                <?php foreach ($gyik as $kerdes => $valasz): ?>
                    <details>
                        <summary><?= e($kerdes) ?></summary>
                        <p><?= e($valasz) ?></p>
                    </details>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
