<?php
    require_once(__DIR__.'/../models/user.php');
    require_once(__DIR__.'/../models/db.php');
    session_start();
    
    
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <link rel="stylesheet" href="/Kolcsonzo/assets/css/style.css">
    <link rel="stylesheet" href="/Kolcsonzo/assets/css/auth.css">
</head>
<body class="auth-page">
    <main>
        <img src="/Kolcsonzo/assets/pics/logo.png" alt="" class="auth-logo">
        <h1>Regisztráció</h1>
        <p class="subtitle">Hozd létre a fiókodat.</p>
        <p><?php 
        checkRegisztracio();
        ?></p>
        <form method="post">
            <input type="email" name="email" id="email" placeholder="E-mail"  required/><br>
            <input type="text" name="Vnev" id="Vnev" placeholder="Vezetéknév" required/><br>
            <input type="text" name="Knev" id="KNev" placeholder="Keresztnév" required/><br>
            <input type="password" name="password" id="password" placeholder="Jelszó" required/><br>
            <input type="password" name="password2" id="password2" placeholder="Jelszó megerősítése" required/><br>
            <input type="text" name="telszam" id="telszam" placeholder="+36301234567" required/><br>

            <label class="checkbox"><input type="checkbox" name="aszf" required>Elfogadom a felhasználási feltételeket</label>

            <button type="submit" name="submit">Regisztráció</button>

        </form>

        <p class="register-text">Már van fiókod? <a href="login.php">Jelentkezz be!</a></p>

    </main>
   <!--- <script src="/Kolcsonzo/assets/js/regisztracio.js"></script>    --->
</body>
</html>
<?php
function checkRegisztracio(){
    global $conn;
    if(isset($_POST["submit"])){
        $email=$_POST["email"];
        $vnev=$_POST["Vnev"];
        $knev=$_POST["Knev"];
        $password1=$_POST["password"];
        $password2=$_POST["password2"];
        $telszam=$_POST["telszam"];
        $errors=[];
        if(empty($email)||empty($vnev)||empty($knev)||empty($password1)||empty($password2)||empty($telszam)){
         array_push($errors, "Minden mező kitöltése kötelező!");
        }elseif($password1!==$password2){
        array_push($errors, "A két jelszó nem egyezik!");
        }
    else{
        
        $stmt = mysqli_prepare($conn,"SELECT * FROM user WHERE email = ?");
        mysqli_stmt_bind_param($stmt,"s",$email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $results = mysqli_fetch_all($result);
        if($results==1){
            array_push($errors,"Ez az e-mail cím már foglalt!");
        }else{
            $hash_pass=password_hash($password1,PASSWORD_BCRYPT);
            $stmt = mysqli_prepare($conn,"INSERT INTO user (VNev, KNev, email, password, telszam) VALUES (?,?,?,?,?)");
            mysqli_stmt_bind_param($stmt,"sssss",$vnev,$knev,$email,$hash_pass,$telszam);
            mysqli_stmt_execute($stmt);

        $stmt = mysqli_prepare($conn,"SELECT * FROM user WHERE email = ?");
        mysqli_stmt_bind_param($stmt,"s",$email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $results = mysqli_fetch_all($result);
        $user = new User($results[0][1],$results[0][2],$results[0][3],$results[0][5]);
        $_SESSION["user"]= $user;
        header("Location:kolcsonzes.php");
            
            


        }

    
  
             
        }
    }
}