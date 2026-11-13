<?php
require_once(__DIR__.'/../models/db.php');

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




}