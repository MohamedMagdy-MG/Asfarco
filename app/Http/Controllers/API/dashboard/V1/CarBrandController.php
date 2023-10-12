<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\CarBrandRepo;
use App\Http\Requests\dashboard\CarBrand\AddCarBrandRequest;
use App\Http\Requests\dashboard\CarBrand\DeleteCarBrandRequest;
use App\Http\Requests\dashboard\CarBrand\UpdateCarBrandRequest;
use App\Models\CarBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CarBrandController extends Controller
{
    public $carBrand;

    public function __construct()
    {
        $this->carBrand = new CarBrandRepo();
         $this->middleware('auth:dashboard');
    }


  
   
    public function getAllCarBrands()
    {
        return $this->carBrand->getAllCarBrands($_GET['search']);
    }

    public function Add(Request $request)
    {
        $validator = Validator::make($request->only(['name_en','name_ar','image']),AddCarBrandRequest::rules(),AddCarBrandRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add Car Brand Operation Failed' : $message = 'فشلت عملية اضافة ماركة السيارة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'image' => $request->image
            ];
            
            return $this->carBrand->Add($data);
        }   
        
    }

    public function Update(Request $request)
    {
        $validator = Validator::make($request->only(['id','name_en','name_ar','image']),UpdateCarBrandRequest::rules(),UpdateCarBrandRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Edit Car Brand Information Operation Failed' : $message = 'فشلت عملية تعديل بيانات ماركة السيارة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'id' => $request->id,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'image' => $request->image
            ];
            
            return $this->carBrand->Update($data);
        }   
        
    }

    public function Delete(Request $request)
    {
        $validator = Validator::make($request->only(['id']),DeleteCarBrandRequest::rules(),DeleteCarBrandRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Delete Car Brand Operation Failed' : $message = 'فشلت عملية حذف ماركة السيارة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->carBrand->Delete($request->id);
        }   
        
    }

   

   
    



   

    



}
