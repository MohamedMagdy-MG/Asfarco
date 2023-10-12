<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\AnalysisRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AnalysisController extends Controller
{
    public $analysisRepo;

    public function __construct()
    {
        $this->analysisRepo = new AnalysisRepo();
        $this->middleware('auth:dashboard');
    }




    public function Cards()
    {
        return $this->analysisRepo->Cards();
    }

   


}
