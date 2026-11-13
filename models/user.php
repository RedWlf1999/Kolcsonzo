<?php 
class User{
    private string $vnev;
    private string $knev;
    private string $email;
    private string $telefonszam;
    

    public function __construct(string $vnev,string $knev,string $email, string $telefonszam){
        $this->vnev=$vnev;
        $this->knev=$knev;
        $this->email=$email;
        $this->telefonszam=$telefonszam;
    }
    public function getFullnev(): string      {return ($this->vnev.' '.$this->knev); }
    public function getEmail(): string      {return $this->email;}
    public function getTelefonszam(): string     {return $this->telefonszam;}
    
    public function IdoPontFogalalasa(){

    }
    public function IdoPontTorlese(){
        
    } 
    public function AdatokModositasa(){

    }
    public function FeltoltDB(){
        
    }


}