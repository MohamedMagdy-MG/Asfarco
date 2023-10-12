<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface FeatureInterface
{
                           
    public function getAllFeaturees($search);
    public function Add($data = []);
    public function Update($data = []);
    public function Delete($id);
                    
}