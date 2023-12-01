<?php

namespace App\Http\Controllers\API\frontend\V1;

use App\Http\Controllers\Controller;
use App\Http\RepoClasses\frontend\AboutAdsRepo;


class AboutAdsController extends Controller
{
    public $aboutAdsRepo;

    public function __construct()
    {
        $this->aboutAdsRepo = new AboutAdsRepo();
    }

    public function ShowAds()
    {
        return $this->aboutAdsRepo->ShowAds();
    }

    

   
   
   
}
