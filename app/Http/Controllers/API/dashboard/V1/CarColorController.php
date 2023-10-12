<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\CarColorRepo;
use App\Http\Requests\dashboard\CarColor\AddCarColorRequest;
use App\Http\Requests\dashboard\CarColor\DeleteCarColorRequest;
use App\Http\Requests\dashboard\CarColor\UpdateCarColorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CarColorController extends Controller
{
    public $CarColor;

    public function __construct()
    {
        $this->CarColor = new CarColorRepo();
         $this->middleware('auth:dashboard');
    }


  
   
    public function getAllCarColors()
    {
        return $this->CarColor->getAllCarColors($_GET['search']);
    }

    public function Add(Request $request)
    {
        $validator = Validator::make($request->only(['name_en','name_ar','hexa_code']),AddCarColorRequest::rules(),AddCarColorRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add Cars Color Operation Failed' : $message = 'فشلت عملية اضافة لون السيارات';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'hexa_code' => $request->hexa_code
            ];
            
            return $this->CarColor->Add($data);
        }   
        
    }

    public function Update(Request $request)
    {
        $validator = Validator::make($request->only(['id','name_en','name_ar','hexa_code']),UpdateCarColorRequest::rules(),UpdateCarColorRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Edit Cars Color Information Operation Failed' : $message = 'فشلت عملية تعديل بيانات لون السيارات';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'id' => $request->id,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'hexa_code' => $request->hexa_code
            ];
            
            return $this->CarColor->Update($data);
        }   
        
    }

    public function Delete(Request $request)
    {
        $validator = Validator::make($request->only(['id']),DeleteCarColorRequest::rules(),DeleteCarColorRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Delete Cars Color Operation Failed' : $message = 'فشلت عملية حذف لون السيارات';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->CarColor->Delete($request->id);
        }   
        
    }

   

   
    



   

    



}
