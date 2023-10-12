<?php

namespace App\Http\Controllers\API\dashboard\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\RepoClasses\dashboard\CarRepo;
use App\Http\Requests\dashboard\Car\ActiveCarRequest;
use App\Http\Requests\dashboard\Car\AddCarRequest;
use App\Http\Requests\dashboard\Car\DeleteCarRequest;
use App\Http\Requests\dashboard\Car\ShowCarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CarController extends Controller
{
    public $carRepo;

    public function __construct()
    {
        $this->carRepo = new CarRepo();
        $this->middleware('auth:dashboard');
    }


    public function getAllCategories()
    {
        return $this->carRepo->getAllCategories();
    }
    public function getAllFuelTypes()
    {
        return $this->carRepo->getAllFuelTypes();
    }
    public function getAllBrands()
    {
        return $this->carRepo->getAllBrands();
    }
    public function getAllModels()
    {
        return $this->carRepo->getAllModels();
    }
    public function getAllModelYears()
    {
        return $this->carRepo->getAllModelYears();
    }
    public function getAllTransmissions()
    {
        return $this->carRepo->getAllTransmissions();
    }
    public function getAllBranches()
    {
        return $this->carRepo->getAllBranches();
    }
    public function getAllFeatures()
    {
        return $this->carRepo->getAllFeatures();
    }
    public function getAllColors()
    {
        return $this->carRepo->getAllColors();
    }

    public function getAllCars()
    {
        return $this->carRepo->getAllCars($_GET['search'],$_GET['category'],$_GET['branch']);
    }
    

    public function Add(Request $request)
    {
       
        $validator = Validator::make($request->only(['name_en','name_ar','description_en','description_ar','bags','passengers','doors','daily','daily_discount','weekly','weekly_discount','monthly','monthly_discount','yearly','yearly_discount','category_id','fuel_id','brand_id','model_id','model_year_id','transmission_id','branch_id','Images','Features','AdditionalFeatures','Colors','airport_transfer_service','airport_transfer_service_price','deliver_to_my_location','deliver_to_my_location_price']),AddCarRequest::rules(),AddCarRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Add Car Operation Failed' : $message = 'فشلت عملية اضافة السيارة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
                'bags' => $request->bags,
                'passengers' => $request->passengers,
                'doors' => $request->doors,
                'daily' => $request->daily,
                'daily_discount' => $request->daily_discount,
                'weekly' => $request->weekly,
                'weekly_discount' => $request->weekly_discount,
                'monthly' => $request->monthly,
                'monthly_discount' => $request->monthly_discount,
                'yearly' => $request->yearly,
                'yearly_discount' => $request->yearly_discount,
                'category_id' => $request->category_id,
                'fuel_id' => $request->fuel_id,
                'brand_id' => $request->brand_id,
                'model_id' => $request->model_id,
                'model_year_id' => $request->model_year_id,
                'transmission_id' => $request->transmission_id,
                'branch_id' => $request->branch_id,
                'Images' => $request->Images,
                'Features' => $request->Features,
                'AdditionalFeatures' => $request->AdditionalFeatures,
                'Colors' => $request->Colors,
                'airport_transfer_service' => $request->airport_transfer_service,
                'airport_transfer_service_price' => $request->airport_transfer_service_price,
                'deliver_to_my_location' => $request->deliver_to_my_location,
                'deliver_to_my_location_price' => $request->deliver_to_my_location_price,
            ];
            
            return $this->carRepo->Add($data);
        }   
        
    }

    public function Update(Request $request)
    {
       
        $validator = Validator::make($request->only(['id','name_en','name_ar','description_en','description_ar','bags','passengers','doors','daily','daily_discount','weekly','weekly_discount','monthly','monthly_discount','yearly','yearly_discount','category_id','fuel_id','brand_id','model_id','model_year_id','transmission_id','branch_id','Images','Features','AdditionalFeatures','Colors','airport_transfer_service','airport_transfer_service_price','deliver_to_my_location','deliver_to_my_location_price']),AddCarRequest::rules(),AddCarRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Update Car Information Operation Failed' : $message = 'فشلت عملية تعديل بيانات السيارة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            $data = [
                'id' => $request->id,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
                'bags' => $request->bags,
                'passengers' => $request->passengers,
                'doors' => $request->doors,
                'daily' => $request->daily,
                'daily_discount' => $request->daily_discount,
                'weekly' => $request->weekly,
                'weekly_discount' => $request->weekly_discount,
                'monthly' => $request->monthly,
                'monthly_discount' => $request->monthly_discount,
                'yearly' => $request->yearly,
                'yearly_discount' => $request->yearly_discount,
                'category_id' => $request->category_id,
                'fuel_id' => $request->fuel_id,
                'brand_id' => $request->brand_id,
                'model_id' => $request->model_id,
                'model_year_id' => $request->model_year_id,
                'transmission_id' => $request->transmission_id,
                'branch_id' => $request->branch_id,
                'Images' => $request->Images,
                'Features' => $request->Features,
                'AdditionalFeatures' => $request->AdditionalFeatures,
                'Colors' => $request->Colors,
                'airport_transfer_service' => $request->airport_transfer_service,
                'deliver_to_my_location' => $request->deliver_to_my_location,
                'airport_transfer_service' => $request->airport_transfer_service,
                'airport_transfer_service_price' => $request->airport_transfer_service_price,
                'deliver_to_my_location' => $request->deliver_to_my_location,
                'deliver_to_my_location_price' => $request->deliver_to_my_location_price,
            ];
            
            return $this->carRepo->Update($data);
        }   
        
    }

    public function Show(Request $request)
    {
        $validator = Validator::make($request->only(['id']),ShowCarRequest::rules(),ShowCarRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Show Car Information Operation Failed' : $message = 'فشلت عملية عرض بيانات السيارة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            return $this->carRepo->Show($request->id);
        }   
        
    }
    public function Delete(Request $request)
    {
        $validator = Validator::make($request->only(['id']),DeleteCarRequest::rules(),DeleteCarRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Delete Car Operation Failed' : $message = 'فشلت عملية حذف السيارة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            return $this->carRepo->Delete($request->id);
        }   
        
    }

    public function Active(Request $request)
    {
        $validator = Validator::make($request->only(['id']),ActiveCarRequest::rules(),ActiveCarRequest::Message());
        if($validator->fails()){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Change Car Status Operation Failed' : $message = 'فشلت عملية تعديل حالة السيارة';
            return Helper::ResponseData(null,$message,false,400,$validator->errors());
        }else{
            
            return $this->carRepo->Active($request->id);
        }   
        
    }


   
    



   

    



}
