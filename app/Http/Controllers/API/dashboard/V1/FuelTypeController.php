<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\FuelTypeRepo;
use App\Http\Requests\dashboard\FuelType\AddFuelTypeRequest;
use App\Http\Requests\dashboard\FuelType\DeleteFuelTypeRequest;
use App\Http\Requests\dashboard\FuelType\UpdateFuelTypeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FuelTypeController extends Controller
{
    public $FuelType;

    public function __construct()
    {
        $this->FuelType = new FuelTypeRepo();
         $this->middleware('auth:dashboard');
    }


  
   
    public function getAllFuelTypes()
    {
        return $this->FuelType->getAllFuelTypes($_GET['search']);
    }

    public function Add(Request $request)
    {
        $validator = Validator::make($request->only(['name_en','name_ar']),AddFuelTypeRequest::rules(),AddFuelTypeRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add Cars Fuel Type Operation Failed' : $message = 'فشلت عملية اضافة نوع وقود السيارات';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
            ];
            
            return $this->FuelType->Add($data);
        }   
        
    }

    public function Update(Request $request)
    {
        $validator = Validator::make($request->only(['id','name_en','name_ar']),UpdateFuelTypeRequest::rules(),UpdateFuelTypeRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Edit Cars Fuel Type Information Operation Failed' : $message = 'فشلت عملية تعديل بيانات نوع وقود السيارات';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'id' => $request->id,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
            ];
            
            return $this->FuelType->Update($data);
        }   
        
    }

    public function Delete(Request $request)
    {
        $validator = Validator::make($request->only(['id']),DeleteFuelTypeRequest::rules(),DeleteFuelTypeRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Delete Cars Fuel Type Operation Failed' : $message = 'فشلت عملية حذف نوع وقود السيارات';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->FuelType->Delete($request->id);
        }   
        
    }

   

   
    



   

    



}
