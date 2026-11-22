<?php 
require_once(__DIR__.'/../models/db.php');
abstract class User{
    
    private int $id;
    protected string $vnev='';
    protected string $knev='';
    protected string $email='';
    protected string $telefonszam='';
    protected string $jogosultsag='';
    

    public function __construct(int $id, string $vnev,string $knev,string $email, string $telefonszam, string $jogosultsag){
        $this->id=$id;    
        $this->vnev=$vnev;
        $this->knev=$knev;
        $this->email=$email;
        $this->telefonszam=$telefonszam;
        $this->jogosultsag=$jogosultsag;
    }
    public function getFullnev(): string      {return ($this->vnev.' '.$this->knev); }
    public function getVnev(): string      {return $this->vnev;}
    public function getKnev(): string      {return $this->knev;}
    public function getEmail(): string      {return $this->email;}
    public function getTelefonszam(): string     {return $this->telefonszam;}
    public function getJog(): string     {return $this->jogosultsag;}
    public function getID(): int     {return $this->id;}

}

class Customer extends User{//3 default
    private string $szemelyig_utlevel;
    private string $jogositvany;
    public function __construct(int $id,
                                string $vnev,
                                string $knev,
                                string $email, 
                                string $telefonszam,
                                string $jogosultsag,
                                string $szemelyig_utlevel,
                                string $jogositvany
                                ){
        parent::__construct( $id,$vnev, $knev, $email, $telefonszam,$jogosultsag);
        $this->szemelyig_utlevel=$szemelyig_utlevel;
        $this->jogositvany=$jogositvany;

    }
    public function getSzemelyUtlevel(): string     {return $this->szemelyig_utlevel;}
    public function getJogositvany(): string     {return $this->jogositvany;}
    
    public function setSzemelyUtlevel(string $adat): void     { $this->szemelyig_utlevel=$adat;}
    public function setJogositvany(string $adat): void     { $this->jogositvany=$adat;}
    public function setVnev(string $adat):void  { $this->vnev=$adat;}
    public function setKnev(string $adat):void      { $this->knev=$adat;}
    public function setEmail(string $adat):void      { $this->email=$adat;}
    public function setTelefonszam(string $adat):void   { $this->telefonszam=$adat;}


    public function AutoFogalalasa(string $rndsz, 
                                    String $mettol, 
                                    string $meddig, 
                                    int $atvetelihely, 
                                    int $telepulesId, 
                                    string $cim, 
                                    string $megjegyzes,
                                    array $extrakListaja){
        global $conn;
        $id = $this->getID();
        $vnev = $this->getVnev();
        $knev = $this->getKnev();
        $okmany = $this->getSzemelyUtlevel();
        $jogositvany = $this->getJogositvany();
        $telefonszam = $this->getTelefonszam();
        $stmt = mysqli_prepare($conn,"INSERT INTO foglalasok (userID, 
                                                            Rendszam, 
                                                            Mikortol, 
                                                            Meddig,
                                                            atvetelihelyID,
                                                            telepulesID,
                                                            szamlazasi_cim,
                                                            megjegyzes,
                                                            VNev,
                                                            KNev,
                                                            Okmany,
                                                            Jogositvany,
                                                            telszam
                                                            ) VALUES (
                                                            ?,?,?,?,?,?,?,?,?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt,"isssiisssssss",
                                    $id,
                                    $rndsz,
                                    $mettol,
                                    $meddig,
                                    $atvetelihely,
                                    $telepulesId,
                                    $cim,
                                    $megjegyzes,
                                    $vnev,
                                    $knev,
                                    $okmany,
                                    $jogositvany,
                                    $telefonszam
                                    );
        mysqli_stmt_execute($stmt);
        
        if (count($extrakListaja) > 0) {
            $ujFoglalasId = (int)mysqli_insert_id($conn);
            $stmtExtra = mysqli_prepare($GLOBALS["conn"], "INSERT INTO foglalas_extrak (foglalasID, extraID) VALUES (?, ?)");
            
            foreach ($extrakListaja as $extraId) {
                $extraIdInt = (int)$extraId;
                mysqli_stmt_bind_param($stmtExtra, "ii", $ujFoglalasId, $extraIdInt);
                mysqli_stmt_execute($stmtExtra);
                }
            }

    
    }
    public function FoglalasLemondasa(string $foglalasId){
            $userId = $this->getID();
            $stmtExtra = mysqli_prepare($GLOBALS["conn"], "DELETE FROM foglalas_extrak WHERE foglalasID=?");
            mysqli_stmt_bind_param($stmtExtra, "i", $foglalasId);
            mysqli_stmt_execute($stmtExtra);
            // A userID = ? feltétel garantálja, hogy más foglalását ne tudja törölni!
            $stmt = mysqli_prepare($GLOBALS["conn"], "DELETE FROM foglalasok WHERE id = ? AND userID = ?");
            mysqli_stmt_bind_param($stmt, "ii", $foglalasId, $userId);
            mysqli_stmt_execute($stmt);
            
            
    }
    public function AdatokModositasa(){
        $vnev = $this->getVnev();
        $knev = $this->getKnev();
        $email  = $this->getEmail();
        $telefon = $this->getTelefonszam();
        $jogsi = $this->getJogositvany();
        $utlevelSzemelyi = $this->getSzemelyUtlevel();
        $id =  $this->getID();
        $stmt = mysqli_prepare($GLOBALS["conn"],"UPDATE user
                                                SET VNev=?, KNev=?, email=?, telszam=?, szemigazolvanyszam=?, jogositvanyszam=?
                                                WHERE id=?");
        mysqli_stmt_bind_param($stmt,"ssssssi",
                                    $vnev,
                                    $knev,
                                    $email,
                                    $telefon,
                                    $jogsi,
                                    $utlevelSzemelyi,
                                    $id);
        mysqli_stmt_execute($stmt);
    }
    public function JelszoModositas(string $uj){
        $id=$this->getID();
        $hash_pass=password_hash($uj,PASSWORD_BCRYPT);
        $stmt = mysqli_prepare($GLOBALS["conn"],"UPDATE user
                                                SET password=?
                                                WHERE id=?");
        mysqli_stmt_bind_param($stmt,"si",
                                    $hash_pass,
                                    $id);
        mysqli_stmt_execute($stmt);

    }
    public function getJelszo(): string{
        $id=$this->getID();
        $stmt = mysqli_prepare($GLOBALS["conn"],"SELECT password FROM user WHERE id = ?");
        mysqli_stmt_bind_param($stmt,"i",$id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $sor=mysqli_fetch_assoc($result);
        return $sor["password"]??'';
       
        
    }
}



class Admin extends User{//1
    public function __construct(int $id,string $vnev,string $knev,string $email, string $telefonszam, string $jogosultsag){
        parent::__construct($id,$vnev, $knev, $email, $telefonszam, $jogosultsag);
        $this->StatuszFrissites();
        

    }
    public function FoglalasStatuszModositas(string $statusz, int $foglalasID){
        
        $stmt = mysqli_prepare($GLOBALS["conn"],"UPDATE foglalasok
                                                SET statusz=?
                                                WHERE id=?");
        mysqli_stmt_bind_param($stmt,"si",
                                    $statusz,
                                    $foglalasID);
        mysqli_stmt_execute($stmt);
        $this->StatuszFrissites();
    }
    public function StatuszFrissites():void{
        $sql1="UPDATE foglalasok SET statusz = 'folyamatban' 
            WHERE statusz = 'jovahagyva' AND Mikortol <= CURDATE()";
        $sql2="UPDATE foglalasok SET statusz = 'lezarva' 
            WHERE statusz = 'folyamatban' AND Meddig < CURDATE()";
        mysqli_query($GLOBALS["conn"],$sql1);
        mysqli_query($GLOBALS["conn"],$sql2);
    }
}
