<?php

namespace App\Http\Controllers\API\frontend\V1;

use App\Http\Controllers\Controller;
use App\Http\RepoClasses\frontend\FleetAdsRepo;


class FleetAdsController extends Controller
{
    public $fleetAdsRepo;

    public function __construct()
    {
        $this->fleetAdsRepo = new FleetAdsRepo();
    }

    public function ShowAds()
    {
        return $this->fleetAdsRepo->ShowAds();
    }

   

   
   
   
}
