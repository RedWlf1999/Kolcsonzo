<?php
class Atvetelihely{
    private int $id;
    private string $hely;
    public function __construct(int $id, string $hely){
        $this->id=$id;
        $this->hely=$hely;
    }
    public function getID(): int      {return $this->id; }
    public function getHely(): string      {return $this->hely;}
}