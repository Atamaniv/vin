<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\VinDecoderService;

class VinDecoderController extends AbstractController
{
    #[Route('/{vin}', name: 'app_vin_decoder')]
        
    public function index ($vin)
    {        
        $vin = new VinDecoderService($vin);

        return $this->render('vin_decoder.html.twig',[
            'vin'=> $vin->getVin(),
            'error'=> $vin->getError(),
            'wmi'=> $vin->wmi(),
            'vds'=> $vin->vds(),
            'vis'=> $vin->vis(),
            'model_year'=> $vin->model_year(),
            'serial_number'=> $vin->serial_number(),
            'assembly_plant'=> $vin->assembly_plant(),
            'region'=> $vin->region(), 
            'country'=> $vin->country(), 
            'years'=> $vin->model_year()
        ]);      
    }
}
