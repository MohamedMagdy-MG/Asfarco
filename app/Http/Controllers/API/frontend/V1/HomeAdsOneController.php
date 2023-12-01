<?php

namespace App\Http\Controllers\API\frontend\V1;

use App\Http\Controllers\Controller;
use App\Http\RepoClasses\frontend\HomeAdsOneRepo;


class HomeAdsOneController extends Controller
{
    public $homeAdsOneRepo;

    public function __construct()
    {
        $this->homeAdsOneRepo = new HomeAdsOneRepo();
    }

    public function ShowAds()
    {
        return $this->homeAdsOneRepo->ShowAds();
    }

    

   
   
   
}
