<?php
        
namespace App\Http\RepoInterfaces\mobile;   

interface HomeInterface
{

    public function getAllHomePageFilter();
    public function getAllFilterPage();
    public function getAllCategories();
    public function getAllHomeCategories();
    public function getAllHomePageCars();
    public function getAllCategoriesWithID();
    public function getAllFuelTypes();
    public function getAllBrands();
    public function getAllHomeBrands();
    public function getAllModels($brand);
    public function getAllModelYears();
    public function getAllTransmissions();
    public function getAllFeatures();
    public function getAllColors();
    public function getAllCars($id,$start_date,$return_date,$price,$brand,$model,$year,$category,$color,$fuel_type,$features,$passengers,$luggae,$transmission);
    public function getAllCarDetailsPageCars($id);
    public function getAllAboutUsPageCars();
    public function getAllSavedCarsPageCars();
                    
}