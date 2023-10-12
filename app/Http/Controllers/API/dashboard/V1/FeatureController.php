<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\FeatureRepo;
use App\Http\Requests\dashboard\Feature\AddFeatureRequest;
use App\Http\Requests\dashboard\Feature\DeleteFeatureRequest;
use App\Http\Requests\dashboard\Feature\UpdateFeatureRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FeatureController extends Controller
{
    public $featureRepo;

    public function __construct()
    {
        $this->featureRepo = new FeatureRepo();
         $this->middleware('auth:dashboard');
    }


  
   
    public function getAllFeaturees()
    {
        return $this->featureRepo->getAllFeaturees($_GET['search']);
    }

    public function Add(Request $request)
    {
        $validator = Validator::make($request->only(['name_en','name_ar']),AddFeatureRequest::rules(),AddFeatureRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add Feature Operation Failed' : $message = 'فشلت عملية اضافة الخدمة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
            ];
            
            return $this->featureRepo->Add($data);
        }   
        
    }

    public function Update(Request $request)
    {
        $validator = Validator::make($request->only(['id','name_en','name_ar']),UpdateFeatureRequest::rules(),UpdateFeatureRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Edit Feature Information Operation Failed' : $message = 'فشلت عملية تعديل بيانات الخدمة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'id' => $request->id,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
            ];
            
            return $this->featureRepo->Update($data);
        }   
        
    }

    public function Delete(Request $request)
    {
        $validator = Validator::make($request->only(['id']),DeleteFeatureRequest::rules(),DeleteFeatureRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Delete Feature Operation Failed' : $message = 'فشلت عملية حذف الخدمة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->featureRepo->Delete($request->id);
        }   
        
    }

   

   
    



   

    



}
