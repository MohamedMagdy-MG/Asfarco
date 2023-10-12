<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface CarModelInterface
{
                           
    public function getAllCarModels($search);
    public function getAllCarBrands();
    public function Add($data = []);
    public function Update($data = []);
    public function Delete($id);
                    
}