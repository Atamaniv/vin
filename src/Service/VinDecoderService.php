<?php

namespace App\Service;

class VinDecoderService {
    private $vin;
    private $error = Array();
    private $Regions=[
        ["/^[A-C]+$/","Africa"],
        ["/^[J-R]+$/",'Asia'],
        ["/^[S-Z]+$/",'Europe'],
        ["/^[1-5]+$/",'North America'],
        ["/^[6-7]+$/",'Oceania'],
        ["/^[8-9]+$/",'South America']];

        private $Countries=[
          ["/W[A-Z0-9]/",'Germany'],
          ["/N([F-K])/",'Pakistan']];        

    function __construct($vin) {
        $this->error=[];
        $this->vin=$vin;

        if (empty($this->vin)) {
            array_push($this->error, "WIN is Empty!");
        }

        if (strlen($this->vin)!=17) {
            array_push($this->error, "Length WIN is not 17 character (".strval(strlen($this->vin)).")");
        }

        if (!preg_match("#^[A-HJ-NP-Z0-9]+$#",$this->vin)) {
            array_push($this->error, "VIN code contains invalid characters I,O,Q,a-z,spesial character");
        }
    }
    
    public function wmi(){
        if ($this->error==[])
          return substr($this->vin,0,3);
        else 
          return "-";
    }

    public function vds(){
        if ($this->error==[])
          return substr($this->vin,3,6);
        else 
          return "-";
    }

    public function vis(){
        if ($this->error==[])
          return substr($this->vin,9,8);
        else 
          return "-";
    }

    public function model_year(){
        if ($this->error==[])
          return substr($this->vin,9,1);
        else 
          return "-";
    }

    public function serial_number(){
        if ($this->error==[])
          return substr($this->vin,12,6);
        else 
          return "-";
    }

    public function assembly_plant(){
        if ($this->error==[])
          return substr($this->vin,10,1);
        else 
          return "-";
    }

    public function region(){
      $res = '';
      if ($this->error==[]){
         for ($row=0;$row<count($this->Regions);$row++) {
          if (preg_match($this->Regions[$row][0],substr($this->vin,0,1))) {
            $res = $this->Regions[$row][1];
          }   
        }
        return $res;
      }
      else 
        return "-";
    }

    public function country(){
      $res = '';
      if ($this->error==[]){
        for ($row=0;$row<count($this->Countries);$row++) {
          if (preg_match($this->Countries[$row][0],substr($this->vin,0,2))) {
            $res = $this->Countries[$row][1];
          }   
        }
        return $res;
      }
      else 
        return "-";
    }

    public function getError(){
        return $this->error;
    }
    public function getVin(){
        return $this->vin;
    }
  }