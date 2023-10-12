<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface CarBrandInterface
{
                           
    public function getAllCarBrands($search);
    public function Add($data = []);
    public function Update($data = []);
    public function Delete($id);
                    
}