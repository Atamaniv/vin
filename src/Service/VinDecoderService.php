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
          ['/1[A-Z0-9]/','United States'],
          ['/2[A-Z0-9]/','Canada'],
          ['/3[8-90]/','not assigned'],
          ['/3[A-W]/','Mexico'],
          ['/3[X-Z1-7]/','Costa Rica'],
          ['/4[A-Z0-9]/','United States'],
          ['/5[A-Z0-9]/','United States'],
          ['/6[A-W]/','Australia'],
          ['/6[X-Z0-9]/','not assigned'],
          ['/7[A-E]/','New Zealand'],
          ['/7[F-Z0-9]/','not assigned'],
          ['/8[3-90]/','not assigned'],
          ['/8[A-E]/','Argentina'],
          ['/8[F-K]/','Chile'],
          ['/8[L-R]/','Ecuador'],
          ['/8[S-W]/','Peru'],
          ['/8[X-Z1-2]/','Venezuela'],
          ['/9[3-9]/','Brazil'],
          ['/9[A-E]/','Brazil'],
          ['/9[F-K]/','Colombia'],
          ['/9[L-R]/','Paraguay'],
          ['/9[S-W]/','Uruguay'],
          ['/9[X-Z1-2]/','Trinidad & Tobago'],
          ['/A[A-H]/','South Africa'],
          ['/A[J-N]/','Ivory Coast'],
          ['/A[P-Z0-9]/','not assigned'],
          ['/B[A-E]/','Angola'],
          ['/B[F-K]/','Kenya'],
          ['/B[L-R]/','Tanzania'],
          ['/B[S-Z0-9]/','not assigned'],
          ['/C[A-E]/','Benin'],
          ['/C[F-K]/','Malagasy'],
          ['/C[L-R]/','Tunisia'],
          ['/C[S-Z0-9]/','not assigned'],
          ['/D[A-E]/','Egypt'],
          ['/D[F-K]/','Morocco'],
          ['/D[L-R]/','Zambia'],
          ['/D[S-Z0-9]/','not assigned'],
          ['/E[A-E]/','Ethiopia'],
          ['/E[F-K]/','Mozambique'],
          ['/E[L-Z0-9]/','not assigned'],
          ['/F[A-E]/','Ghana'],
          ['/F[F-K]/','Nigeria'],
          ['/F[F-K]/','Madagascar'],
          ['/F[L-Z0-9]/','not assigned'],
          ['/G[A-Z0-9]/','not assigned'],
          ['/H[A-Z0-9]/','not assigned'],
          ['/J[A-Z0-9]/','Japan'],
          ['/K[A-E]/','Sri Lanka'],
          ['/K[F-K]/','Israel'],
          ['/K[L-R]/','Korea (South)'],
          ['/K[S-Z0-9]/','not assigned'],
          ['/L[A-Z0-9]/','China'],
          ['/M[A-E]/','India'],
          ['/M[F-K]/','Indonesia'],
          ['/M[L-R]/','Thailand'],
          ['/M[S-Z0-9]/','not assigned'],
          ['/N[F-K]/','Pakistan'],
          ['/N[L-R]/','Turkey'],
          ['/N[S-Z0-9]/','not assigned'],
          ['/P[A-E]/','Philipines'],
          ['/P[F-K]/','Singapore'],
          ['/P[L-R]/','Malaysia'],
          ['/P[S-Z0-9]/','not assigned'],
          ['/R[A-E]/','United Arab Emirates'],
          ['/R[F-K]/','Taiwan'],
          ['/R[L-R]/','Vietnam'],
          ['/R[S-Z0-9]/','not assigned'],
          ['/S[0-9]/','not assigned'],
          ['/S[A-M]/','Great Britain'],
          ['/S[N-T]/','Germany'],
          ['/S[U-Z]/','Poland'],
          ['/T[2-90]/','not assigned'],
          ['/T[A-H]/','Switzerland'],
          ['/T[J-P]/','Czechoslovakia'],
          ['/T[R-V]/','Hungary'],
          ['/T[W-Z1]/','Portugal'],
          ['/U[1-4]/','not assigned'],
          ['/U[5-7]/','Slovakia'],
          ['/U[8-90]/','not assigned'],
          ['/U[A-G]/','not assigned'],
          ['/U[H-M]/','Denmark'],
          ['/U[N-T]/','Ireland'],
          ['/U[U-Z]/','Romania'],
          ['/V[3-5]/','Croatia'],
          ['/V[6-90]/','Estonia'],
          ['/V[A-E]/','Austria'],
          ['/V[F-R]/','France'],
          ['/V[S-W]/','Spain'],
          ['/V[X-Z1-2]/','Yugoslavia'],
          ['/W[A-Z0-9]/','Germany'],
          ['/X[3-90]/','Russia'],
          ['/X[A-E]/','Bulgaria'],
          ['/X[F-K]/','Greece'],
          ['/X[L-R]/','Netherlands'],
          ['/X[S-W]/','U.S.S.R.'],
          ['/X[X-Z1-2]/','Luxembourg'],
          ['/Y[3-5]/','Belarus'],
          ['/Y[6-90]/','Ukraine'],
          ['/Y[A-E]/','Belgium'],
          ['/Y[F-K]/','Finland'],
          ['/Y[L-R]/','Malta'],
          ['/Y[S-W]/','Sweden'],
          ['/Y[X-Z1-2]/','Norway'],
          ['/Z[3-5]/','Lithuania'],
          ['/Z[6-90]/','not assigned'],
          ['/Z[A-R]/','Italy'],
          ['/Z[S-W]/','not assigned'],
          ['/Z[X-Z1-2]/','Slovenia'],
          ['/90/','Not ussigned'] ];        

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