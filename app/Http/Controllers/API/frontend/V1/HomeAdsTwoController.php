<?php

namespace App\Http\Controllers\API\frontend\V1;

use App\Http\Controllers\Controller;
use App\Http\RepoClasses\frontend\HomeAdsTwoRepo;


class HomeAdsTwoController extends Controller
{
    public $homeAdsTwoRepo;

    public function __construct()
    {
        $this->homeAdsTwoRepo = new HomeAdsTwoRepo();
    }

    public function ShowAds()
    {
        return $this->homeAdsTwoRepo->ShowAds();
    }

   

   
   
   
}
