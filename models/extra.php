<?php
class Extra{
    private int $id;
    private string $nev;
    private int $ar;
    private string $ikon;
    public function __construct(int $id, string $nev, int $ar, string $ikon){
        $this->id=$id;
        $this->nev=$nev;
        $this->ar=$ar;
        $this->ikon=$ikon;
    }
    public function getID(): int      {return $this->id; }
    public function getNev(): string      {return $this->nev;}
    public function getAr(): int      {return $this->ar; }
    public function getIkon(): string      {return $this->ikon;}
}