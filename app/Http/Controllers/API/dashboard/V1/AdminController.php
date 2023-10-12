<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\AdminRepo;
use App\Http\Requests\dashboard\Admins\AddAdminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    public $adminRepo;

    public function __construct()
    {
        $this->adminRepo = new AdminRepo();
        $this->middleware('auth:dashboard');
    }




    public function getAllAdmins()
    {
        return $this->adminRepo->getAllAdmins($_GET['search']);
    }

    public function Add(Request $request)
    {
       
        $validator = Validator::make($request->only(['name_en','name_ar','gender','email','image']),AddAdminRequest::rules(),AddAdminRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add System Administrator Operation Failed' : $message = 'فشلت عملية اضافة مسؤل للنظام';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'gender' => $request->gender,
                'email' => $request->email,
                'image' => $request->image,
            ];
            
            return $this->adminRepo->Add($data);
        }   
        
    }

    


}
