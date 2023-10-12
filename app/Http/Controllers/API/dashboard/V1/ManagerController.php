<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\ManagerRepo;
use App\Http\Requests\dashboard\Managers\ActiveManagersRequest;
use App\Http\Requests\dashboard\Managers\AddManagersRequest;
use App\Http\Requests\dashboard\Managers\DeleteManagersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ManagerController extends Controller
{
    public $managerRepo;

    public function __construct()
    {
        $this->managerRepo = new ManagerRepo();
         $this->middleware('auth:dashboard');
    }




    public function getAllManagers()
    {
        return $this->managerRepo->getAllManagers($_GET['search']);
    }

    public function Add(Request $request)
    {
       
        $validator = Validator::make($request->only(['name_en','name_ar','gender','email','image']),AddManagersRequest::rules(),AddManagersRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add Manager Operation Failed' : $message = 'فشلت عملية اضافة المدير';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'gender' => $request->gender,
                'email' => $request->email,
                'image' => $request->image,
            ];
            
            return $this->managerRepo->Add($data);
        }   
        
    }

    public function Delete(Request $request)
    {
        $validator = Validator::make($request->only(['id']),DeleteManagersRequest::rules(),DeleteManagersRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Delete Manager Operation Failed' : $message = 'فشلت عملية حذف المدير';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->managerRepo->Delete($request->id);
        }   
        
    }

    public function Active(Request $request)
    {
        $validator = Validator::make($request->only(['id']),ActiveManagersRequest::rules(),ActiveManagersRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Change Manager Status Operation Failed' : $message = 'فشلت عملية تعديل حالة المدير';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->managerRepo->Active($request->id);
        }   
        
    }


   
    



   

    



}
