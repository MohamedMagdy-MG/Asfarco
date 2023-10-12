<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\CarCategoryRepo;
use App\Http\Requests\dashboard\CarCategory\AddCarCategoryRequest;
use App\Http\Requests\dashboard\CarCategory\DeleteCarCategoryRequest;
use App\Http\Requests\dashboard\CarCategory\UpdateCarCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CarCategoryController extends Controller
{
    public $carCategory;

    public function __construct()
    {
        $this->carCategory = new CarCategoryRepo();
         $this->middleware('auth:dashboard');
    }


  
   
    public function getAllCarCategories()
    {
        return $this->carCategory->getAllCarCategories($_GET['search']);
    }

    public function Add(Request $request)
    {
        $validator = Validator::make($request->only(['name_en','name_ar','image']),AddCarCategoryRequest::rules(),AddCarCategoryRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add Cars Category Operation Failed' : $message = 'فشلت عملية اضافة قسم السيارات';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'image' => $request->image,
            ];
            
            return $this->carCategory->Add($data);
        }   
        
    }

    public function Update(Request $request)
    {
        $validator = Validator::make($request->only(['id','name_en','name_ar','image']),UpdateCarCategoryRequest::rules(),UpdateCarCategoryRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Edit Cars Category Information Operation Failed' : $message = 'فشلت عملية تعديل بيانات قسم السيارات';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'id' => $request->id,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'image' => $request->image
            ];
            
            return $this->carCategory->Update($data);
        }   
        
    }

    public function Delete(Request $request)
    {
        $validator = Validator::make($request->only(['id']),DeleteCarCategoryRequest::rules(),DeleteCarCategoryRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Delete Cars Category Operation Failed' : $message = 'فشلت عملية حذف قسم السيارات';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->carCategory->Delete($request->id);
        }   
        
    }

   

   
    



   

    



}
