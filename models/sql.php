<?php
require_once(__DIR__.'/../models/db.php');
//require_once(__DIR__.'/../models/car.php');

class Sql{
     public function __construct(private mysqli $db){}
    
    public function AutokListaja(): ?array{
        $sql = "SELECT * FROM cars 
                                INNER JOIN automarka on cars.MarkaID = automarka.id 
                                INNER JOIN kategoriak on cars.kategoriaID = kategoriak.id
                                INNER JOIN valtotipusok on cars.valtoID = valtotipusok.id
                                INNER JOIN uzemanyagtipusok on cars.uzemanyagID = uzemanyagtipusok.id";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $autok= [];
        while($row =  mysqli_fetch_assoc($result)){
                
            $autok[] = new Car(
                $row['Rendszam'],
                $row['Marka'],
                $row['Modell'],
                $row['kategoria'],
                $row['kep'],
                (int)$row['Ar'],
                (int)$row['ulesek'],
                (int)$row['csomagter'],
                $row['Tipus'],
                $row['tipus'],
                (int)$row['gyartasiEv'],
                (float)$row['fogyasztas'],
                $row['leiras'],
            );
        }
        return $autok;
        //return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    public function AtveteliHelyek(): ?array{
        $sql = "SELECT * FROM atvetelihelyek";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $atvetelihelyek = [];
         while($row =  mysqli_fetch_assoc($result)){
            $atvetelihelyek[] = new Atvetelihely($row['id'],$row['hely']); 
         }
         return  $atvetelihelyek;
    }
     public function Extrak(): ?array{
        $sql = "SELECT * FROM extrak";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $extraLista = [];
         while($row =  mysqli_fetch_assoc($result)){
            $extraLista[] = new Extra($row['id'],$row['nev'],$row['ar'],$row['ikon']); 
         }
         return  $extraLista;
    }
    public function getAuto(string $rndsz):?array{
        $stmt = mysqli_prepare($this->db,"SELECT * FROM cars WHERE Rendszam = ?");
        mysqli_stmt_bind_param($stmt,"s",$rndsz);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $results = mysqli_fetch_all($result);
        return $results;

    }
    public function getTelepulesID(int $irsz) : int {
        $stmt = mysqli_prepare($this->db,"SELECT * FROM telepulesek WHERE IRSZ = ?");
        mysqli_stmt_bind_param($stmt,"i",$irsz);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $results = mysqli_fetch_assoc($result);
        return $results['id'];
    }
    public function SzabadAutok(string $atvetel, string $leadas): ?array{
        $sql = "SELECT * FROM cars 
                                INNER JOIN automarka on cars.MarkaID = automarka.id 
                                INNER JOIN kategoriak on cars.kategoriaID = kategoriak.id
                                INNER JOIN valtotipusok on cars.valtoID = valtotipusok.id
                                INNER JOIN uzemanyagtipusok on cars.uzemanyagID = uzemanyagtipusok.id
                                 WHERE NOT EXISTS (
                                        SELECT 1 FROM foglalasok
                                        WHERE foglalasok.Rendszam = cars.Rendszam
                                        AND foglalasok.statusz IN ('fuggoben', 'jovahagyva', 'folyamatban')
                                        AND foglalasok.Mikortol <= ?
                                        AND foglalasok.Meddig >= ?)";
        $stmt = mysqli_prepare($this->db, $sql);
         mysqli_stmt_bind_param($stmt, "ss", $leadas, $atvetel);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $szabad_autok=[];
        while($row =  mysqli_fetch_assoc($result)){
                
             $szabad_autok[] = new Car(
                $row['Rendszam'],
                $row['Marka'],
                $row['Modell'],
                $row['kategoria'],
                $row['kep'],
                (int)$row['Ar'],
                (int)$row['ulesek'],
                (int)$row['csomagter'],
                $row['Tipus'],
                $row['tipus'],
                (int)$row['gyartasiEv'],
                (float)$row['fogyasztas'],
                $row['leiras'],
            );
        }
        return $szabad_autok;
        //return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
     public static function Kategoriak(): ?array{
        $sql = "SELECT * FROM kategoriak";
        $stmt = mysqli_prepare($GLOBALS["conn"], $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $kategoriak=[];
        while($row =  mysqli_fetch_assoc($result)){
                
            $kategoriak[] = $row["kategoria"];
        }
        return $kategoriak;
        //return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
     



}