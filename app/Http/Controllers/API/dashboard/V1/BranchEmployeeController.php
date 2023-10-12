<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\BranchEmployeeRepo;
use App\Http\Requests\dashboard\BranchEmployees\ActiveBranchEmployeesRequest;
use App\Http\Requests\dashboard\BranchEmployees\AddBranchEmployeesRequest;
use App\Http\Requests\dashboard\BranchEmployees\DeleteBranchEmployeesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BranchEmployeeController extends Controller
{
    public $branchEmployeeRepo;

    public function __construct()
    {
        $this->branchEmployeeRepo = new BranchEmployeeRepo();
         $this->middleware('auth:dashboard');
    }




    public function getAllBranchEmployees()
    {
        return $this->branchEmployeeRepo->getAllBranchEmployees($_GET['search'],$_GET['branch']);
    }

    public function getAllBranches()
    {
        return $this->branchEmployeeRepo->getAllBranches($_GET['search']);
    }
    
    public function Add(Request $request)
    {
       
        $validator = Validator::make($request->only(['name_en','name_ar','gender','email','image','branch']),AddBranchEmployeesRequest::rules(),AddBranchEmployeesRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add Branch Employee Operation Failed' : $message = 'فشلت عملية اضافة موظف الفرع';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'gender' => $request->gender,
                'email' => $request->email,
                'image' => $request->image,
                'branch' => $request->branch
            ];
            
            return $this->branchEmployeeRepo->Add($data);
        }   
        
    }

    public function Delete(Request $request)
    {
        $validator = Validator::make($request->only(['id']),DeleteBranchEmployeesRequest::rules(),DeleteBranchEmployeesRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Delete Branch Employee Operation Failed' : $message = 'فشلت عملية حذف موظف الفرع';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->branchEmployeeRepo->Delete($request->id);
        }   
        
    }

    public function Active(Request $request)
    {
        $validator = Validator::make($request->only(['id']),ActiveBranchEmployeesRequest::rules(),ActiveBranchEmployeesRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Change Branch Employee Status Operation Failed' : $message = 'فشلت عملية تعديل حالة موظف الفرع';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->branchEmployeeRepo->Active($request->id);
        }   
        
    }


   
    



   

    



}
