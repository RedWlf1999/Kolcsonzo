<?php
class Car{
    private int $id;
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
        int $id, string $marka, string $modell, string $kategoria, string $kep,
        int $ar, int $ulesek, int $csomagter, string $valto, string $uzemanyag,
        int $ev, string $fogyasztas, string $leiras
    ) {
        $this->id = $id;
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
    public function getId(): int            {return $this->id; }
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

    public function getTeljesNev(): string { return $this->marka . ' ' . $this->modell; }

    public static function osszes(): array {
        return [
            new Car(id: 1, marka: 'teszt', modell: 'teszt', kategoria: 'Kompakt', kep: 'placeholder_picture.png',
                    ar: 12000, ulesek: 5, csomagter: 380, valto: 'Manuális', uzemanyag: 'Benzin',
                    ev: 2022, fogyasztas: '5,2 l/100 km',
                    leiras: 'tesztElek.'),

            new Car(id: 2, marka: 'teszt2', modell: 'teszt2', kategoria: 'Kompakt', kep: 'placeholder_picture.png',
                    ar: 15000, ulesek: 5, csomagter: 400, valto: 'Manuális', uzemanyag: 'Benzin',
                    ev: 2024, fogyasztas: '7,2 l/100 km',
                    leiras: 'tesztElek.'),

            new Car(id: 3, marka: 'teszt3', modell: 'teszt', kategoria: 'Kompakt', kep: 'placeholder_picture.png',
                    ar: 12000, ulesek: 5, csomagter: 380, valto: 'Automata', uzemanyag: 'Dízel',
                    ev: 2022, fogyasztas: '5,2 l/100 km',
                    leiras: 'tesztElek.'),

            new Car(id: 4, marka: 'teszt4', modell: 'teszt', kategoria: 'Kompakt', kep: 'placeholder_picture.png',
                    ar: 10000, ulesek: 5, csomagter: 380, valto: 'Manuális', uzemanyag: 'Benzin',
                    ev: 2020, fogyasztas: '5,2 l/100 km',
                    leiras: 'tesztElek.'),


            new Car(id: 5, marka: 'teszt5', modell: 'teszt', kategoria: 'Kompakt', kep: 'placeholder_picture.png',
                    ar: 20000, ulesek: 5, csomagter: 380, valto: 'Automata', uzemanyag: 'Dízel',
                    ev: 2026, fogyasztas: '5,2 l/100 km',
                    leiras: 'tesztElek.')
        ];

    }

        public static function keres(int $id): ?Car {
        foreach (self::osszes() as $car) {
            if ($car->getId() === $id) {
                return $car;
            }
        }
        return null;
    }

}
