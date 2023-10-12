<?php
        
namespace App\Http\RepoInterfaces\mobile;   

interface HomeInterface
{
                                      
    public function getAllCategories();
    public function getAllHomePageCars();
    public function getAllCategoriesWithID();
    public function getAllFuelTypes();
    public function getAllBrands();
    public function getAllModels($brand);
    public function getAllModelYears();
    public function getAllTransmissions();
    public function getAllFeatures();
    public function getAllColors();
    public function getAllCars($id,$price,$brand,$model,$year,$category,$color,$fuel_type,$features,$passengers,$luggae,$transmission);
    public function getAllCarDetailsPageCars();
    public function getAllAboutUsPageCars();
    public function getAllSavedCarsPageCars();
                    
}