<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\CarModelRepo;
use App\Http\Requests\dashboard\CarModel\AddCarModelRequest;
use App\Http\Requests\dashboard\CarModel\DeleteCarModelRequest;
use App\Http\Requests\dashboard\CarModel\UpdateCarModelRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CarModelController extends Controller
{
    public $CarModel;

    public function __construct()
    {
        $this->CarModel = new CarModelRepo();
         $this->middleware('auth:dashboard');
    }


  
   
    public function getAllCarModels()
    {
        return $this->CarModel->getAllCarModels($_GET['search']);
    }

    public function getAllCarBrands()
    {
        return $this->CarModel->getAllCarBrands();
    }

    public function Add(Request $request)
    {
        $validator = Validator::make($request->only(['name_en','name_ar','car_brand_id']),AddCarModelRequest::rules(),AddCarModelRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add Car Brand Operation Failed' : $message = 'فشلت عملية اضافة طراز السيارة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'car_brand_id' => $request->car_brand_id
            ];
            
            return $this->CarModel->Add($data);
        }   
        
    }

    public function Update(Request $request)
    {
        $validator = Validator::make($request->only(['id','name_en','name_ar','car_brand_id']),UpdateCarModelRequest::rules(),UpdateCarModelRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Edit Car Brand Information Operation Failed' : $message = 'فشلت عملية تعديل بيانات طراز السيارة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'id' => $request->id,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'car_brand_id' => $request->car_brand_id
            ];
            
            return $this->CarModel->Update($data);
        }   
        
    }

    public function Delete(Request $request)
    {
        $validator = Validator::make($request->only(['id']),DeleteCarModelRequest::rules(),DeleteCarModelRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Delete Car Brand Operation Failed' : $message = 'فشلت عملية حذف طراز السيارة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->CarModel->Delete($request->id);
        }   
        
    }

   

   
    



   

    



}
