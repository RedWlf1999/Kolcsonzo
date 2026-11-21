<?php
    require_once(__DIR__.'/../models/user.php');
    require_once(__DIR__.'/../models/db.php');
    session_start();
    changeData();
    $user=$_SESSION["user"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <label> Vezetéknév<br>
        <input type="text" name="" value=<?=  $user->getVnev()?>  placeholder="Vezetéknév"/><button type="submit" name = "newVnev">Módosítás</button><br>
        </label>
        <input type="text" name="" value="<?=  $user->getknev()?>" placeholder="Keresztnév"/><button type="submit" name = "newKnev">Módosítás</button><br>
        <input type="text" name="" value="<?=  $user->getEmail()?>" placeholder="E-mail cím"/><button type="submit" name = "newEmail">Módosítás</button><br>
        <input type="text" name="" value="<?=  $user->getTelefonszam()?>" placeholder="Telefonszám"/><button type="submit" name = "newTelefonszam">Módosítás</button><br>
        <input type="text" name="" value="<?=  $user->getSzemelyJogositvany()?>" placeholder="Személyigazolványszám/Útlevél" /><button  type="submit" name = "newUtlevelSzemelyi">Módosítás</button><br>
        <input type="text" name="" value="<?=  $user->getJogositvany()?>" placeholder="Jogosítvány száma"/><button  type="submit" name = "newJogsi">Módosítás</button><br>
        <input type="password" name=""  placeholder="Régi jelszó"/><br>
        <input type="password" name=""  placeholder="Új jelszó"/><br>
        <input type="password" name=""  placeholder="Új jelszó újra"/><button  type="submit" name = "newPass">Módosítás</button><br>

    </form>
    
</body>
</html>

<?php
function changeData(){
    if(isset($_POST["submit"])){
        global $conn;
        $kNev=$_POST["newKnev"];
        $vNev=$_POST["newVnev"];
        $telefon = $_POST["newTelefonszam"];
        $okmany=$_POST["newUtlevelSzemelyi"];
        $jogsi=$_POST["newJogsi"];

        $stmt = mysqli_prepare($conn,"UPDATE user (newKnev) VALUES (?)");
        mysqli_stmt_bind_param($stmt,"s",$vnev,$knev,$email,$hash_pass,$telszam);
        mysqli_stmt_execute($stmt);
    }
}