<?php
namespace App\Http\RepoInterfaces\dashboard;


interface AnalysisInterface {
   
    public function Cards();
    public function Charts($year);
    public function BranchCharts($year);
    public function LatestOnGoing();
    public function LatestCompleted();
}