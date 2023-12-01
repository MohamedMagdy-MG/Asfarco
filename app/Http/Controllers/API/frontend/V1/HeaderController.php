<?php

namespace App\Http\Controllers\API\frontend\V1;

use App\Http\Controllers\Controller;
use App\Http\RepoClasses\frontend\HeaderRepo;


class HeaderController extends Controller
{
    public $headerRepo;

    public function __construct()
    {
        $this->headerRepo = new HeaderRepo();
    }

    public function ShowHeader()
    {
        return $this->headerRepo->ShowHeader();
    }

    

   
   
   
}
