<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\BranchRepo;
use App\Http\Requests\dashboard\Branch\ActiveBranchRequest;
use App\Http\Requests\dashboard\Branch\AddBranchRequest;
use App\Http\Requests\dashboard\Branch\DeleteBranchRequest;
use App\Http\Requests\dashboard\Branch\UpdateBranchRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BranchController extends Controller
{
    public $branchRepo;

    public function __construct()
    {
        $this->branchRepo = new BranchRepo();
         $this->middleware('auth:dashboard');
    }


  
    public function getAllCities()
    {
        return $this->branchRepo->getAllCities();
    }

    public function getAllBranches()
    {
        return $this->branchRepo->getAllBranches($_GET['search'],$_GET['city']);
    }

    public function Add(Request $request)
    {
        $validator = Validator::make($request->only(['name_en','name_ar','address_en','address_ar','longitude','latitude','city_id','mobile']),AddBranchRequest::rules(),AddBranchRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add Branch Operation Failed' : $message = 'فشلت عملية اضافة الفرع';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'address_en' => $request->address_en,
                'address_ar' => $request->address_ar,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'city_id' => $request->city_id,
                'mobile' => $request->mobile
            ];
            
            return $this->branchRepo->Add($data);
        }   
        
    }

    public function Update(Request $request)
    {
        $validator = Validator::make($request->only(['id','name_en','name_ar','address_en','address_ar','longitude','latitude','city_id','mobile']),UpdateBranchRequest::rules(),UpdateBranchRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Edit Branch Information Operation Failed' : $message = 'فشلت عملية تعديل بيانات الفرع';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'id' => $request->id,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'address_en' => $request->address_en,
                'address_ar' => $request->address_ar,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'city_id' => $request->city_id,
                'mobile' => $request->mobile
            ];
            
            return $this->branchRepo->Update($data);
        }   
        
    }

    public function Delete(Request $request)
    {
        $validator = Validator::make($request->only(['id']),DeleteBranchRequest::rules(),DeleteBranchRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Delete Branch Operation Failed' : $message = 'فشلت عملية حذف الفرع';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->branchRepo->Delete($request->id);
        }   
        
    }

    public function Active(Request $request)
    {
        $validator = Validator::make($request->only(['id']),ActiveBranchRequest::rules(),ActiveBranchRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Change Branch Status Operation Failed' : $message = 'فشلت عملية تعديل حالة الفرع';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            
            return $this->branchRepo->Active($request->id);
        }   
        
    }


   
    



   

    



}
