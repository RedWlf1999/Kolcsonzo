<?php
require_once __DIR__ . '/car.php';

class Booking {
    private int $id;
    private int $autoId;
    private string $nev;
    private string $email;
    private string $atvetel;
    private string $leadas;
    private string $hely;
    private string $statusz;
    private string $letrehozva;

    public function __construct(
        int $id, int $autoId, string $nev, string $email, string $atvetel,
        string $leadas, string $hely, string $statusz, string $letrehozva
    ) {
        $this->id = $id;
        $this->autoId = $autoId;
        $this->nev = $nev;
        $this->email = $email;
        $this->atvetel = $atvetel;
        $this->leadas = $leadas;
        $this->hely = $hely;
        $this->statusz = $statusz;
        $this->letrehozva = $letrehozva;
    }

    //Getterek
    public function getId(): int            { return $this->id; }
    public function getAutoId(): int        { return $this->autoId; }
    public function getNev(): string        { return $this->nev; }
    public function getEmail(): string      { return $this->email; }
    public function getAtvetel(): string    { return $this->atvetel; }
    public function getLeadas(): string     { return $this->leadas; }
    public function getHely(): string       { return $this->hely; }
    public function getStatusz(): string    { return $this->statusz; }
    public function getLetrehozva(): string { return $this->letrehozva; }

    // A foglalt autó
    public function getAuto(): ?Car {
        return Car::keres($this->autoId);
    }

    // Hány napra szól a foglalás
    public function getNapok(): int {
        return (int) ((strtotime($this->leadas) - strtotime($this->atvetel)) / 86400);
    }

    // A bérleti díj összesen (napi ár × napok)
    public function getOsszeg(): int {
        $auto = $this->getAuto();
        return $auto ? $auto->getAr() * $this->getNapok() : 0;
    }

    // Az átvételi hely olvasható neve
    public function getHelyNev(): string {
        $helyek = [
            'belvaros'  => 'Budapest – Belváros',
            'repuloter' => 'Budapest – Liszt Ferenc repülőtér',
            'gyor'      => 'Győr',
        ];
        return $helyek[$this->hely] ?? $this->hely;
    }

    // A státusz olvasható neve
    public function getStatuszNev(): string {
        $statuszok = [
            'fuggoben'    => 'Függőben',
            'jovahagyva'  => 'Jóváhagyva',
            'folyamatban' => 'Folyamatban',
            'lezarva'     => 'Lezárva',
            'lemondva'    => 'Lemondva',
        ];
        return $statuszok[$this->statusz] ?? $this->statusz;
    }

    // Dátum kiírása magyar formában, pl. 2026. 10. 31.
    public static function datum(string $datum): string {
        return date('Y. m. d.', strtotime($datum));
    }

    // A mai naptól számított dátum, pl. nap(5) = 5 nap múlva, nap(-3) = 3 napja
    private static function nap(int $eltolas): string {
        return date('Y-m-d', strtotime($eltolas . ' days'));
    }

    // ===== Ál-adatok =====
    public static function osszes(): array {
        return [
            new Booking(id: 1, autoId: 3, nev: 'Teszt Elek', email: 'teszt.elek@email.hu',
                        atvetel: self::nap(5), leadas: self::nap(9), hely: 'belvaros',
                        statusz: 'fuggoben', letrehozva: self::nap(-1)),

            new Booking(id: 2, autoId: 5, nev: 'Teszt Elek', email: 'teszt.elek@email.hu',
                        atvetel: self::nap(20), leadas: self::nap(23), hely: 'repuloter',
                        statusz: 'jovahagyva', letrehozva: self::nap(-4)),

            new Booking(id: 3, autoId: 1, nev: 'Teszt Elek', email: 'teszt.elek@email.hu',
                        atvetel: self::nap(-30), leadas: self::nap(-26), hely: 'belvaros',
                        statusz: 'lezarva', letrehozva: self::nap(-40)),

            new Booking(id: 4, autoId: 2, nev: 'Teszt Elek', email: 'teszt.elek@email.hu',
                        atvetel: self::nap(-60), leadas: self::nap(-58), hely: 'gyor',
                        statusz: 'lemondva', letrehozva: self::nap(-70)),

            new Booking(id: 5, autoId: 2, nev: 'Kovács Anna', email: 'kovacs.anna@email.hu',
                        atvetel: self::nap(-1), leadas: self::nap(3), hely: 'repuloter',
                        statusz: 'folyamatban', letrehozva: self::nap(-8)),

            new Booking(id: 6, autoId: 4, nev: 'Nagy Péter', email: 'nagy.peter@email.hu',
                        atvetel: self::nap(2), leadas: self::nap(6), hely: 'belvaros',
                        statusz: 'fuggoben', letrehozva: self::nap(0)),

            new Booking(id: 7, autoId: 1, nev: 'Szabó Júlia', email: 'szabo.julia@email.hu',
                        atvetel: self::nap(10), leadas: self::nap(14), hely: 'gyor',
                        statusz: 'jovahagyva', letrehozva: self::nap(-2)),

            new Booking(id: 8, autoId: 5, nev: 'Tóth Gábor', email: 'toth.gabor@email.hu',
                        atvetel: self::nap(-10), leadas: self::nap(-5), hely: 'belvaros',
                        statusz: 'lezarva', letrehozva: self::nap(-15)),
        ];
    }

    public static function keres(int $id): ?Booking {
        foreach (self::osszes() as $foglalas) {
            if ($foglalas->getId() === $id) {
                return $foglalas;
            }
        }
        return null;
    }

    // Egy felhasználó foglalásai (a név alapján)
    public static function felhasznaloFoglalasai(string $nev): array {
        $eredmeny = [];
        foreach (self::osszes() as $foglalas) {
            if ($foglalas->getNev() === $nev) {
                $eredmeny[] = $foglalas;
            }
        }
        return $eredmeny;
    }
}
