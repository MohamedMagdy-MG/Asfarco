<?php

namespace App\Http\Controllers\API\frontend\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\frontend\HomeRepo;
use App\Http\RepoClasses\frontend\ProfileRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{
    public $homeRepo;

    public function __construct()
    {
        $this->homeRepo = new HomeRepo();
    }
    public function getAllCategories()
    {
        return $this->homeRepo->getAllCategories();
    }
    public function getAllHomePageCars()
    {
        $category = null;
        if(array_key_exists('category',$_GET)){
            $category = $_GET['category'];
        }
        return $this->homeRepo->getAllHomePageCars($category);
    }
    public function getAllCategoriesWithID()
    {
        return $this->homeRepo->getAllCategoriesWithID();
    }
    public function getAllFuelTypes()
    {
        return $this->homeRepo->getAllFuelTypes();
    }
    public function getAllBrands()
    {
        return $this->homeRepo->getAllBrands();
    }
    public function getAllModels()
    {
        $brand = null;
        if(array_key_exists('brand',$_GET)){
            $brand = $_GET['brand'];
        }
        return $this->homeRepo->getAllModels($brand);
    }
    public function getAllModelYears()
    {
        return $this->homeRepo->getAllModelYears();
    }
    public function getAllTransmissions()
    {
        return $this->homeRepo->getAllTransmissions();
    }
    public function getAllFeatures()
    {
        return $this->homeRepo->getAllFeatures();
    }
    public function getAllColors()
    {
        return $this->homeRepo->getAllColors();
    }
    public function getAllCars()
    {
        $id = null;
        if(array_key_exists('id',$_GET)){
            $id = $_GET['id'];
        }
        $start_date = null;
        if(array_key_exists('start_date',$_GET)){
            $start_date = $_GET['start_date'];
        }
        $return_date = null;
        if(array_key_exists('return_date',$_GET)){
            $return_date = $_GET['return_date'];
        }
        $price = null;
        if(array_key_exists('price',$_GET)){
            $price = $_GET['price'];
        }
        $brand = null;
        if(array_key_exists('brand',$_GET)){
            $brand = $_GET['brand'];
        }
        $model = null;
        if(array_key_exists('model',$_GET)){
            $model = $_GET['model'];
        }
        $year = null;
        if(array_key_exists('year',$_GET)){
            $year = $_GET['year'];
        }
        $category = null;
        if(array_key_exists('category',$_GET)){
            $category = $_GET['category'];
        }
        $color = null;
        if(array_key_exists('color',$_GET)){
            $color = $_GET['color'];
        }
        $fuel_type = null;
        if(array_key_exists('fuel_type',$_GET)){
            $fuel_type = $_GET['fuel_type'];
        }
        $features = null;
        if(array_key_exists('features',$_GET)){
            $features = $_GET['features'];
        }
        $passengers = null;
        if(array_key_exists('passengers',$_GET)){
            $passengers = $_GET['passengers'];
        }
        $luggae = null;
        if(array_key_exists('luggae',$_GET)){
            $luggae = $_GET['luggae'];
        }
        $transmission = null;
        if(array_key_exists('transmission',$_GET)){
            $transmission = $_GET['transmission'];
        }
        return $this->homeRepo->getAllCars($id,$start_date,$return_date,$price,$brand,$model,$year,$category,$color,$fuel_type,$features,$passengers,$luggae,$transmission);
    }
    public function getAllCarDetailsPageCars()
    {
        $id = null;
        if(array_key_exists('id',$_GET)){
            $id = $_GET['id'];
        }
        return $this->homeRepo->getAllCarDetailsPageCars($id);
    }
    public function getAllAboutUsPageCars()
    {
        return $this->homeRepo->getAllAboutUsPageCars();
    }
    public function getAllSavedCarsPageCars()
    {
        return $this->homeRepo->getAllSavedCarsPageCars();
    }
    public function getAllBranches()
    {
        return $this->homeRepo->getAllBranches();
    }



    



   

    



}
