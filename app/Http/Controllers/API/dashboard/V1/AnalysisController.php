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

    public function Charts(){
        $year = null;
        if(array_key_exists('year',$_GET)){
            $year = $_GET['year'];
        }
        return $this->analysisRepo->Charts($year);
    
    }

    public function BranchCharts(){
        $year = null;
        if(array_key_exists('year',$_GET)){
            $year = $_GET['year'];
        }
        return $this->analysisRepo->BranchCharts($year);
    
    }
    public function LatestOnGoing(){
        
        return $this->analysisRepo->LatestOnGoing();
    
    }
    public function LatestCompleted(){
        
        return $this->analysisRepo->LatestCompleted();
    
    }
   


}
