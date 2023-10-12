<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\ModelYearRepo;
use App\Http\Requests\dashboard\ModelYear\AddModelYearRequest;
use App\Http\Requests\dashboard\ModelYear\DeleteModelYearRequest;
use App\Http\Requests\dashboard\ModelYear\UpdateModelYearRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ModelYearController extends Controller
{
    public $ModelYear;

    public function __construct()
    {
        $this->ModelYear = new ModelYearRepo();
         $this->middleware('auth:dashboard');
    }


  
   
    public function getAllModelYears()
    {
        return $this->ModelYear->getAllModelYears($_GET['search']);
    }

    public function Add(Request $request)
    {
        $validator = Validator::make($request->only(['year']),AddModelYearRequest::rules(),AddModelYearRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add Cars Model Year Operation Failed' : $message = 'فشلت عملية اضافة سنة الصنع السيارات';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'year' => $request->year,
            ];
            
            return $this->ModelYear->Add($data);
        }   
        
    }

    public function Update(Request $request)
    {
        $validator = Validator::make($request->only(['id','year']),UpdateModelYearRequest::rules(),UpdateModelYearRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Edit Cars Model Year Information Operation Failed' : $message = 'فشلت عملية تعديل بيانات سنة الصنع السيارات';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'id' => $request->id,
                'year' => $request->year,
            ];
            
            return $this->ModelYear->Update($data);
        }   
        
    }

    public function Delete(Request $request)
    {
        $validator = Validator::make($request->only(['id']),DeleteModelYearRequest::rules(),DeleteModelYearRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Delete Cars Model Year Operation Failed' : $message = 'فشلت عملية حذف سنة الصنع السيارات';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->ModelYear->Delete($request->id);
        }   
        
    }

   

   
    



   

    



}
