<?php
class Car{
    private string $rendszam;
    private string $marka;
    private string $modell;
    private string $kategoria;
    private string $kep;
    private int $ar;
    private int $ulesek;
    private int $csomagter;
    private string $valto;
    private string $uzemanyag;
    private int $ev;
    private string $fogyasztas;
    private string $leiras;

    public function __construct(
        string $rendszam, string $marka, string $modell, string $kategoria, string $kep,
        int $ar, int $ulesek, int $csomagter, string $valto, string $uzemanyag,
        int $ev, string $fogyasztas, string $leiras
    ) {
        $this->rendszam = $rendszam;
        $this->marka = $marka;
        $this->modell = $modell;
        $this->kategoria = $kategoria;
        $this->kep = $kep;
        $this->ar = $ar;
        $this->ulesek = $ulesek;
        $this->csomagter = $csomagter;
        $this->valto = $valto;
        $this->uzemanyag = $uzemanyag;
        $this->ev = $ev;
        $this->fogyasztas = $fogyasztas;
        $this->leiras = $leiras;
    }

    //Getterek
    public function getRndsz(): string      {return $this->rendszam; }
    public function getMarka(): string      {return $this->marka;}
    public function getModell(): string     {return $this->modell;}
    public function getKategoria(): string  {return $this->kategoria;}
    public function getKep(): string        {return $this->kep;}
    public function getAr(): int            {return $this->ar;}
    public function getUlesek(): int        {return $this->ulesek;}
    public function getCsomagter(): int     {return $this->csomagter;}
    public function getValto(): string      {return $this->valto;}
    public function getUzemanyag(): string  {return $this->uzemanyag;}
    public function getEv(): int            {return $this->ev;}
    public function getFogyasztas(): string {return $this->fogyasztas;}
    public function getLeiras(): string     {return $this->leiras;}
    public function setKep(string $adat): void   { $this->kep=$adat;}

    public function getTeljesNev(): string { return $this->rendszam . ' '.$this->marka . ' ' . $this->modell . ' ' .$this->kategoria. ' '.$this->ev; }
    public static function Keres(string $rndsz){
         $sql = "SELECT * FROM cars 
                                INNER JOIN automarka on cars.MarkaID = automarka.id 
                                INNER JOIN kategoriak on cars.kategoriaID = kategoriak.id
                                INNER JOIN valtotipusok on cars.valtoID = valtotipusok.id
                                INNER JOIN uzemanyagtipusok on cars.uzemanyagID = uzemanyagtipusok.id
                                WHERE cars.Rendszam=? AND aktiv=1";
        $stmt = mysqli_prepare($GLOBALS["conn"], $sql);
        mysqli_stmt_bind_param($stmt, "s", $rndsz);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $auto=null;
        while($row =  mysqli_fetch_assoc($result)){
                
            $auto = new Car(
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
                $row['fogyasztas'],
                $row['leiras'],
            );
        }
        return $auto;
    }




#region
    /*public static function osszes(): array {
        return [
            new Car(rendszam: 'test1', marka: 'teszt', modell: 'teszt', kategoria: 'Kompakt', kep: 'placeholder_picture.png',
                    ar: 12000, ulesek: 5, csomagter: 380, valto: 'Manuális', uzemanyag: 'Benzin',
                    ev: 2022, fogyasztas: '5,2 l/100 km',
                    leiras: 'tesztElek.'),

            new Car(rendszam: 'test2', marka: 'teszt2', modell: 'teszt2', kategoria: 'Kompakt', kep: 'placeholder_picture.png',
                    ar: 15000, ulesek: 5, csomagter: 400, valto: 'Manuális', uzemanyag: 'Benzin',
                    ev: 2024, fogyasztas: '7,2 l/100 km',
                    leiras: 'tesztElek.'),

            new Car(rendszam: 'test3', marka: 'teszt3', modell: 'teszt', kategoria: 'Kompakt', kep: 'placeholder_picture.png',
                    ar: 12000, ulesek: 5, csomagter: 380, valto: 'Automata', uzemanyag: 'Dízel',
                    ev: 2022, fogyasztas: '5,2 l/100 km',
                    leiras: 'tesztElek.'),

            new Car(rendszam: 'test4', marka: 'teszt4', modell: 'teszt', kategoria: 'Kompakt', kep: 'placeholder_picture.png',
                    ar: 10000, ulesek: 5, csomagter: 380, valto: 'Manuális', uzemanyag: 'Benzin',
                    ev: 2020, fogyasztas: '5,2 l/100 km',
                    leiras: 'tesztElek.'),


            new Car(rendszam: 'test5', marka: 'teszt5', modell: 'teszt', kategoria: 'Kompakt', kep: 'placeholder_picture.png',
                    ar: 20000, ulesek: 5, csomagter: 380, valto: 'Automata', uzemanyag: 'Dízel',
                    ev: 2026, fogyasztas: '5,2 l/100 km',
                    leiras: 'tesztElek.')
        ];

    }

    
        */
#endregion
}
