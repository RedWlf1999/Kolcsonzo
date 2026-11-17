<?php 
require_once(__DIR__.'/../models/db.php');
class User{
    
    private int $id;
    private string $vnev;
    private string $knev;
    private string $email;
    private string $telefonszam;
    private string $jogosultsag;
    

    public function __construct(int $id, string $vnev,string $knev,string $email, string $telefonszam, string $jogosultsag){
        $this->id=$id;    
        $this->vnev=$vnev;
        $this->knev=$knev;
        $this->email=$email;
        $this->telefonszam=$telefonszam;
        $this->jogosultsag=$jogosultsag;
    }
    public function getFullnev(): string      {return ($this->vnev.' '.$this->knev); }
    public function getEmail(): string      {return $this->email;}
    public function getTelefonszam(): string     {return $this->telefonszam;}
    public function getJog(): string     {return $this->jogosultsag;}
    public function getID(): int     {return $this->id;}
    
    public function IdoPontTorlese(){
        
    } 
    public function AdatokModositasa(){

    }
    public function FeltoltDB(){
        
    }


}
class Customer extends User{//3 default
    private string $szemelyig_utlevel="";
    private string $jogositvany="";
    public function __construct(int $id,string $vnev,string $knev,string $email, string $telefonszam, string $jogosultsag){
        parent::__construct( $id,$vnev, $knev, $email, $telefonszam,$jogosultsag);

    }
    public function getSzemelyJogositvany(): string     {return $this->szemelyig_utlevel;}
    public function getJogositvany(): string     {return $this->jogositvany;}
    public function setSzemelyJogositvany(string $adat): void     { $this->szemelyig_utlevel=$adat;}
    public function setJogositvany(string $adat): void     { $this->jogositvany=$adat;}

    public function AutoFogalalasa(string $rndsz, String $mettol, string $meddig, int $atvetelihely, int $telepulesId, string $cim, string $megjegyzes){
        global $conn;
        $statusz="fuggoben";
        $id = $this->getID();
        $stmt = mysqli_prepare($conn,"INSERT INTO foglalasok (userID, 
                                                            Rendszam, 
                                                            Mikortol, 
                                                            Meddig, 
                                                            atvetelihelyID,
                                                            telepulesID,
                                                            szamlazasi_cim,
                                                            megjegyzes,
                                                            statusz
                                                            ) VALUES (
                                                            ?,?,?,?,?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt,"isssiisis",
                                    $id,
                                    $rndsz,
                                    $mettol,
                                    $meddig,
                                    $atvetelihely,
                                    $telepulesId,
                                    $cim,
                                    $megjegyzes,
                                    $statusz);
        mysqli_stmt_execute($stmt);

    
    }
}

class Worker extends User{//2
    public function __construct(int $id,string $vnev,string $knev,string $email, string $telefonszam, string $jogosultsag){
        parent::__construct($id,$vnev, $knev, $email, $telefonszam,$jogosultsag);
    }
}

class Admin extends User{//1
    public function __construct(int $id,string $vnev,string $knev,string $email, string $telefonszam, string $jogosultsag){
        parent::__construct($id,$vnev, $knev, $email, $telefonszam, $jogosultsag);
    }
}
