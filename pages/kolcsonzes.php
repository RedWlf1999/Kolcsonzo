<?php
    require_once(__DIR__.'/../models/user.php');
    require_once(__DIR__.'/../models/db.php');
    
    session_start();
    $user=$_SESSION["user"];
    require __DIR__ . '/../models/car.php';
    require __DIR__ . '/../models/sql.php';
    require_once(__DIR__.'/../models/helyek.php');
    require_once(__DIR__.'/../models/extra.php');
    
    $sql = new Sql($conn);

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
//$extrak = ['gyerekules' => ['nev' => 'Gyerekülés',    'ar' => 2000, 'ikon' => 'fa-baby'],];
$extrakListaja=$sql->Extrak();
$ma = date('Y-m-d');
$legkesobbiSzuletes = date('Y-m-d', strtotime('-21 years'));

$legkesobbiJogsi = date('Y-m-d', strtotime('-1 year'));
//?vissza=' . urlencode($_SERVER['REQUEST_URI'])
#region
/*$autok = Car::osszes();




*/

foglalas($sql);

#endregion
$pageTitle = 'Foglalás';
$pageCss = 'kolcsonzes.css';

//tömbök
$autok=[];
$atvetelihelyek = $sql->AtveteliHelyek();
$autokJs = [];
foreach ($sql->AutokListaja() as $a) {
    $autokJs[$a->getRndsz()] = [
        'nev' => $a->getTeljesNev(),
        'ar'  => $a->getAr(),
        'kep' => $a->getKep(),
    ];
}


$valasztottId =  $_GET['auto_rndsz'] ?? '';
$atvetel = $_GET['atvetel'] ?? '';
$leadas  = $_GET['leadas'] ?? '';
if ($atvetel !== '' && $leadas !== '' && $atvetel <= $leadas) {
    $autok = $sql->SzabadAutok($atvetel, $leadas);
} else {
    $autok = $sql->AutokListaja();
}




include __DIR__ . '/../includes/header.php';
?>
<script>

    const AUTOK = <?= json_encode($autokJs, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;
</script>

<section class="page-banner">
    <h1>Autó foglalása</h1>
</section>

<main class="page">
    <form method="post" class="booking-layout">

        <div class="booking-form">

            <section class="form-section">
                <h2><span class="step">1</span> Autó és időpont</h2>
                 <div class="form-row">
                    <label>Átvétel
                        <input type="date" id="atvetel" name="atvetel" value="<?= htmlspecialchars($atvetel??$_POST["atvetel"]) ?>" min="<?= $ma ?>" required>
                    </label>
                    <label>Leadás
                        <input type="date" id="leadas" name="leadas" value="<?= htmlspecialchars($leadas??$_POST["leadas"]) ?>" min="<?= $ma ?>" required>
                    </label>
                </div>

                <label>Autó
                   
                     <select name="auto_rndsz" id="auto" <?= ($atvetel === '' || $leadas === '')? 'disabled' : '' ?> required>
                        <option value="">Válassz autót…</option>
                        <?php foreach ($autok as $auto): ?>
                           <option value="<?= e($auto->getRndsz()) ?>" <?= $auto->getRndsz() === $valasztottId ? 'selected' : '' ?>>
                                <?= e($auto->getTeljesNev()) ?> – <?= number_format($auto->getAr(), 0, ',', ' ') ?> Ft/nap
                            </option>
                            
                        <?php endforeach; ?>
                    </select>
                     <script>
                    
                    </script>
                </label>
                 <?php  /*<option value="<?= htmlspecialchars($auto->getRndsz()) ?> ">
                                <?= htmlspecialchars($auto->getTeljesNev()) ?>
                            </option>*/?>
               
                <label>Átvételi hely
                    <select name="hely" required>
                        <option value="">Hol szeretnéd átvenni?</option>
                        <?php foreach ($atvetelihelyek as $hely): ?>
                           
                            <option value="<?= htmlspecialchars($hely->getID()) ?> ">
                                <?= htmlspecialchars($hely->getHely()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </section>

            <section class="form-section">
                <h2><span class="step">2</span> Extrák</h2>
                <div class="extras">
                    <?php foreach ($extrakListaja as  $extra): ?>
                        <label class="extra">
                            <input type="checkbox" name="extrak[]" value="<?= $extra->getID() ?>" data-ar="<?= $extra->getAr() ?>">
                            <i class="fa-solid <?= $extra->getIkon() ?>"></i>
                            <span class="extra-name"><?= $extra->getNev(); ?></span>
                            <span class="extra-price">+<?= number_format($extra->getAr(), 0, ',', ' ') ?> Ft/nap</span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="form-section">
                <h2><span class="step">3</span> Személyes adatok</h2>
                <div class="form-row">
                    <label>Teljes név
                        <input type="text" name="nev" value = <?= $_SESSION["user"]->getFullnev() ?>  required>
                    </label>
                    <label>Születési dátum
                        <input type="date" name="szuletesi_datum" max="<?= $legkesobbiSzuletes ?>" required>
                        <small>Legalább 21 évesnek kell lenned.</small>
                    </label>
                </div>
                <div class="form-row">
                    <label>Telefonszám
                        <input type="tel" name="telefon" placeholder="+36 30 123 4567" value = <?= $_SESSION["user"]->getTelefonszam() ?> required >
                    </label>
                    <label>E-mail
                        <input type="email" name="email" value = <?= $_SESSION["user"]->getEmail() ?> required>
                    </label>
                </div>
                <div class="form-row form-row-3">
                    <label>Irányítószám
                        <input type="text" id="irsz" name="iranyitoszam" pattern="[0-9]{4}" maxlength="4"
                               placeholder="1234" title="4 számjegy" required>
                    </label>
                    <label>Település
                        <input type="text" id="telep" name="telepules" required>
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
                        <input type="text" name="szemelyi_szam" placeholder="123456AB" value=<?= $user->getSzemelyUtlevel() ?>
                               pattern="[A-Za-z0-9]{6,9}" title="6–9 karakter, csak betű és szám" required>
                    </label>
                    <label>Jogosítvány száma
                        <input type="text" name="jogsi_szam" placeholder="AB123456"  value=<?= $user->getJogositvany() ?>
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

            <button type="submit" class="btn-accent-full" name="submit">Foglalás véglegesítése</button>
        </aside>
    </form>
</main>
<script>
    const irszInput = document.getElementById('irsz');
    const varosInput = document.getElementById('telep');

    irszInput.addEventListener('blur', function() {
        const irsz = irszInput.value.trim();

        // Csak akkor indítunk lekérdezést, ha 4 számjegyből áll
        if (/^\d{4}$/.test(irsz)) {
            fetch('../models/varos_keres.php?irsz=' + irsz)
                .then(response => response.json())
                .then(data => {
                    if (data.varos) {
                        varosInput.value = data.varos;
                    } else {
                        varosInput.value = '';
                        alert('Nincs ilyen irányítószám az adatbázisban!');
                    }
                })
                .catch(error => console.error('Hiba történt:', error));
        }
    });
   </script>
  

<script src="/Kolcsonzo/assets/js/kolcsonzes.js"></script>

<script>
    const datumAtvetel = document.getElementById('atvetel');
    const datumLeadas = document.getElementById('leadas');
    const autoValaszto = document.getElementById('auto');

    // 1. Oldalbetöltéskor CSAK az autón futtatjuk le a kolcsonzes.js-t (ez nem tölti újra az oldalt!)
    const voltDisabled = autoValaszto.disabled;
    autoValaszto.disabled = false;
    autoValaszto.dispatchEvent(new Event('change'));
    autoValaszto.disabled = voltDisabled;

    // 2. CSAK EZUTÁN kötjük rá a dátumokra az újratöltő függvényt, hogy csak valódi felhasználói kattintásra fusson le
    function datumValtozott() {
        if (datumAtvetel.value !== '' && datumLeadas.value !== '') {
            const kivalasztottAuto = autoValaszto.value || "<?= htmlspecialchars($valasztottId) ?>";
            window.location.href = `?auto_rndsz=${kivalasztottAuto}&atvetel=${datumAtvetel.value}&leadas=${datumLeadas.value}`;
        }
    }

    datumAtvetel.addEventListener('change', datumValtozott);
    datumLeadas.addEventListener('change', datumValtozott);
</script>
<?php
include __DIR__ . '/../includes/footer.php'; 
function foglalas(Sql $sql){
    global $user;
    if(isset($_POST["submit"])){
        $extrak = $_POST["extrak"]??[];
        $user->AutoFogalalasa(
                              $_POST["auto_rndsz"],
                              $_POST["atvetel"],
                              $_POST["leadas"],
                              $_POST["hely"],
                              $sql->getTelepulesID($_POST["iranyitoszam"]),
                              $_POST["cim"],
                              $_POST["megjegyzes"]??'',
                              $extrak
                              );

        Header("Location:foglalasaim.php");
    }
}

