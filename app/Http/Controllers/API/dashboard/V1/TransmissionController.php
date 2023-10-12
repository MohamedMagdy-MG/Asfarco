<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\TransmissionRepo;
use App\Http\Requests\dashboard\Transmission\AddTransmissionRequest;
use App\Http\Requests\dashboard\Transmission\DeleteTransmissionRequest;
use App\Http\Requests\dashboard\Transmission\UpdateTransmissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TransmissionController extends Controller
{
    public $Transmission;

    public function __construct()
    {
        $this->Transmission = new TransmissionRepo();
         $this->middleware('auth:dashboard');
    }


  
   
    public function getAllTransmissions()
    {
        return $this->Transmission->getAllTransmissions($_GET['search']);
    }

    public function Add(Request $request)
    {
        $validator = Validator::make($request->only(['name_en','name_ar']),AddTransmissionRequest::rules(),AddTransmissionRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add Cars Transmission Operation Failed' : $message = 'فشلت عملية اضافة انتقال السيارات';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
            ];
            
            return $this->Transmission->Add($data);
        }   
        
    }

    public function Update(Request $request)
    {
        $validator = Validator::make($request->only(['id','name_en','name_ar']),UpdateTransmissionRequest::rules(),UpdateTransmissionRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Edit Cars Transmission Information Operation Failed' : $message = 'فشلت عملية تعديل بيانات انتقال السيارات';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'id' => $request->id,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
            ];
            
            return $this->Transmission->Update($data);
        }   
        
    }

    public function Delete(Request $request)
    {
        $validator = Validator::make($request->only(['id']),DeleteTransmissionRequest::rules(),DeleteTransmissionRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Delete Cars Transmission Operation Failed' : $message = 'فشلت عملية حذف انتقال السيارات';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->Transmission->Delete($request->id);
        }   
        
    }

   

   
    



   

    



}
