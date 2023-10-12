<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\BranchManagerRepo;
use App\Http\Requests\dashboard\BranchManagers\ActiveBranchManagersRequest;
use App\Http\Requests\dashboard\BranchManagers\AddBranchManagersRequest;
use App\Http\Requests\dashboard\BranchManagers\DeleteBranchManagersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BranchManagerController extends Controller
{
    public $branchManagerRepo;

    public function __construct()
    {
        $this->branchManagerRepo = new BranchManagerRepo();
         $this->middleware('auth:dashboard');
    }




    public function getAllBranchManagers()
    {
        return $this->branchManagerRepo->getAllBranchManagers($_GET['search'],$_GET['branch']);
    }

    public function getAllBranches()
    {
        return $this->branchManagerRepo->getAllBranches($_GET['search']);
    }
    

    public function Add(Request $request)
    {
       
        $validator = Validator::make($request->only(['name_en','name_ar','gender','email','image','branch']),AddBranchManagersRequest::rules(),AddBranchManagersRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add Branch Manager Operation Failed' : $message = 'فشلت عملية اضافة مدير الفرع';
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
            
            return $this->branchManagerRepo->Add($data);
        }   
        
    }

    public function Delete(Request $request)
    {
        $validator = Validator::make($request->only(['id']),DeleteBranchManagersRequest::rules(),DeleteBranchManagersRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Delete Branch Manager Operation Failed' : $message = 'فشلت عملية حذف مدير الفرع';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->branchManagerRepo->Delete($request->id);
        }   
        
    }

    public function Active(Request $request)
    {
        $validator = Validator::make($request->only(['id']),ActiveBranchManagersRequest::rules(),ActiveBranchManagersRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Change Branch Manager Status Operation Failed' : $message = 'فشلت عملية تعديل حالة مدير الفرع';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->branchManagerRepo->Active($request->id);
        }   
        
    }


   
    



   

    



}
