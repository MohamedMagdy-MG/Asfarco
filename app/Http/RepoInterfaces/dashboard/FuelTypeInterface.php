<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface FuelTypeInterface
{
                           
    public function getAllFuelTypes($search);
    public function Add($data = []);
    public function Update($data = []);
    public function Delete($id);
                    
}