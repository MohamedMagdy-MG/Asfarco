<?php
        
namespace App\Http\RepoInterfaces\dashboard;   

interface CarInterface
{
                           
    public function getAllCategories();
    public function getAllFuelTypes();
    public function getAllBrands();
    public function getAllModels();
    public function getAllModelYears();
    public function getAllTransmissions();
    public function getAllBranches();
    public function getAllFeatures();
    public function getAllColors();
    public function getAllCars($search,$category,$branch);
    public function Show($id);
    public function Add($data = []);
    public function Update($data = []);
    public function Delete($id);
    public function Active($id);
                    
}