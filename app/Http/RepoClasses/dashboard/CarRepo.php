<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\CarInterface;
use App\Http\Resources\dashboard\BranchCustomResource;
use App\Http\Resources\dashboard\CarBrandCustomResource;
use App\Http\Resources\dashboard\CarCategoryCustomResource;
use App\Http\Resources\dashboard\CarColorCustomResource;
use App\Http\Resources\dashboard\CarDetailsResource;
use App\Http\Resources\dashboard\CarModelCustomResource;
use App\Http\Resources\dashboard\CarResource;
use App\Http\Resources\dashboard\FeatureCustomResource;
use App\Http\Resources\dashboard\FuelTypeCustomResource;
use App\Http\Resources\dashboard\ModelYearResource;
use App\Http\Resources\dashboard\TransmissionCustomResource;
use App\Models\Branch;
use App\Models\Car;
use App\Models\CarAdditionalFeatures;
use App\Models\CarBrand;
use App\Models\CarCategory;
use App\Models\CarColor;
use App\Models\CarFeatures;
use App\Models\CarHasColors;
use App\Models\CarImages;
use App\Models\CarModel;
use App\Models\Feature;
use App\Models\FuelType;
use App\Models\ModelYear;
use App\Models\Transmission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CarRepo implements CarInterface
{
       
    
    public $car;
    public $category;
    public $fuelType;
    public $brand;
    public $model;
    public $modelYear;
    public $transmission;
    public $branch;
    public $feature;
    public $color;
    public $carImages;
    public $carFeatures;
    public $carAdditionalFeatures;
    public $carHasColors;

    public function __construct()
    {
        
        $this->car = new Car();
        $this->category = new CarCategory();
        $this->fuelType = new FuelType();
        $this->brand = new CarBrand();
        $this->model = new CarModel();
        $this->modelYear = new ModelYear();
        $this->transmission = new Transmission();
        $this->branch = new Branch();
        $this->feature = new Feature();
        $this->color = new CarColor();
        $this->carImages = new CarImages();
        $this->carFeatures = new CarFeatures();
        $this->carAdditionalFeatures = new CarAdditionalFeatures();
        $this->carHasColors = new CarHasColors();
    }

    public function getAllCategories(){
        
        $category = $this->category->orderBy('name_en','asc')->latest()->get();
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Categories Operation Success' : $message = 'نجحت عملية الحصول علي كل الاقسام ';
        return Helper::ResponseData(CarCategoryCustomResource::collection($category),$message,true,200);
    }
    public function getAllFuelTypes(){
        
        $fuelType = $this->fuelType->orderBy('name_en','asc')->latest()->get();
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Fuel Types Operation Success' : $message = 'نجحت عملية الحصول علي كل انواع الوقود ';
        return Helper::ResponseData(FuelTypeCustomResource::collection($fuelType),$message,true,200);
    }
    public function getAllBrands(){
        
        $brand = $this->brand->orderBy('name_en','asc')->latest()->get();
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Brands Operation Success' : $message = 'نجحت عملية الحصول علي كل الماركات ';
        return Helper::ResponseData(CarBrandCustomResource::collection($brand),$message,true,200);
    }
    public function getAllModels(){
        
        $model = $this->model->orderBy('name_en','asc')->latest()->get();
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Models Operation Success' : $message = 'نجحت عملية الحصول علي كل الطرازات ';
        return Helper::ResponseData(CarModelCustomResource::collection($model),$message,true,200);
    }
    public function getAllModelYears(){
        
        $modelYear = $this->modelYear->orderBy('year','asc')->latest()->get();
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Model Years Operation Success' : $message = 'نجحت عملية الحصول علي كل سنين الصنع ';
        return Helper::ResponseData(ModelYearResource::collection($modelYear),$message,true,200);
    }
    public function getAllTransmissions(){
        
        $transmission = $this->transmission->orderBy('name_en','asc')->latest()->get();
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Transmissions Operation Success' : $message = 'نجحت عملية الحصول علي كل انتقالات الحركة ';
        return Helper::ResponseData(TransmissionCustomResource::collection($transmission),$message,true,200);
    }
    public function getAllBranches(){
        
        $branch = $this->branch->orderBy('name_en','asc')->latest()->get();
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Branches Operation Success' : $message = 'نجحت عملية الحصول علي كل الفروع ';
        return Helper::ResponseData(BranchCustomResource::collection($branch),$message,true,200);
    }
    public function getAllFeatures(){
        
        $feature = $this->feature->orderBy('name_en','asc')->latest()->get();
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Features Operation Success' : $message = 'نجحت عملية الحصول علي كل الاضافات ';
        return Helper::ResponseData(FeatureCustomResource::collection($feature),$message,true,200);
    }
    public function getAllColors(){
        
        $color = $this->color->orderBy('name_en','asc')->latest()->get();
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Colors Operation Success' : $message = 'نجحت عملية الحصول علي كل الالوان ';
        return Helper::ResponseData(CarColorCustomResource::collection($color),$message,true,200);
    }
    public function getAllCars($search,$category,$branch){
        if(Auth::guard('dashboard')->user()->role == 'Branch Manager' || Auth::guard('dashboard')->user()->role == 'Branch Employee'){
            $car = $this->car->whereHas('Branch',function(Builder $query){
                $query->where('uuid',Auth::guard('dashboard')->user()->branch_id);
            });
        }else{
            $car = $this->car;
        }
        if($branch != null){
            $car = $car->where(function(Builder $query) use($branch){
                $query->whereHas('Branch',function(Builder $query) use($branch){
                    $query->where('uuid',$branch);
                });
               
            });
            
        }
        if($category != null){
            $car = $car->where(function(Builder $query) use($category){
                $query->whereHas('Category',function(Builder $query) use($category){
                    $query->where('uuid',$category);
                });
               
            });
            
        }
        if($search != null){
            $car = $car->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%')
                ->orWhereHas('Brand',function(Builder $query) use($search){
                    $query->where('name_en','LIKE','%'.$search.'%')
                    ->orWhere('name_ar','LIKE','%'.$search.'%');
                })
                ->orWhereHas('Model',function(Builder $query) use($search){
                    $query->where('name_en','LIKE','%'.$search.'%')
                    ->orWhere('name_ar','LIKE','%'.$search.'%');
                });
            });
            
        }
        
        $car = $car->latest()->paginate(10);
        $data = [
            'Cars' => CarResource::collection($car),
            'Pagination' => [
                'total'       => $car->total(),
                'count'       => $car->count(),
                'perPage'     => $car->perPage(),
                'currentPage' => $car->currentPage(),
                'totalPages'  => $car->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Car Operation Success' : $message = 'نجحت عملية الحصول علي كل السيارات ';

        return Helper::ResponseData($data,$message,true,200);
    }
    public function Show($id){   
        if(Auth::guard('dashboard')->user()->role == 'Branch Manager' || Auth::guard('dashboard')->user()->role == 'Branch Employee'){
            $car = $this->car->where('uuid',$id)->whereHas('Branch',function(Builder $query){
                $query->where('uuid',Auth::guard('dashboard')->user()->branch_id);
            })->first();
        }else{
            $car = $this->car->where('uuid',$id)->first();
        }
        if(!$car){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Car Not Found' : $message = 'السيارة غير موجودة';
            return Helper::ResponseData(null,$message,false,404);
        }



        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Show Car information Operation Success' : $message = 'نجحت عملية عرض بيانات السيارة';

        return Helper::ResponseData(new CarDetailsResource($car),$message,true,200);

        

    }
    public function Add($data = []){ 
        
        $category = $this->category->where('uuid',$data['category_id'])->first();
        if(!$category){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Category Not Found' : $message = 'قسم غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $fuelType = $this->fuelType->where('uuid',$data['fuel_id'])->first();
        if(!$fuelType){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Fuel Type Not Found' : $message = 'نوع الوقود غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $brand = $this->brand->where('uuid',$data['brand_id'])->first();
        if(!$brand){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Brand Not Found' : $message = 'الماركة غير موجودة';
            return Helper::ResponseData(null,$message,false,404);
        }

        $model = $this->model->where('uuid',$data['model_id'])->first();
        if(!$model){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Model Not Found' : $message = 'الطراز غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $modelYear = $this->modelYear->where('uuid',$data['model_year_id'])->first();
        if(!$modelYear){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Model Year Not Found' : $message = 'سنة الصنع غير موجودة';
            return Helper::ResponseData(null,$message,false,404);
        }

        $transmission = $this->transmission->where('uuid',$data['transmission_id'])->first();
        if(!$transmission){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Transmission Not Found' : $message = 'ناقل الحركة غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $branch = $this->branch->where('uuid',$data['branch_id'])->first();
        if(!$branch){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Branch Not Found' : $message = 'فرع غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $carData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
            'description_en' => $data['description_en'],
            'description_ar' => $data['description_ar'],
            'description_two_en' => $data['description_two_en'],
            'description_two_ar' => $data['description_two_ar'],
            'bags' => $data['bags'],
            'passengers' => $data['passengers'],
            'doors' => $data['doors'],
            'daily' => $data['daily'],
            'daily_discount' => $data['daily_discount'],
            'weekly' => $data['weekly'],
            'weekly_discount' => $data['weekly_discount'],
            'monthly' => $data['monthly'],
            'monthly_discount' => $data['monthly_discount'],
            'yearly' => $data['yearly'],
            'yearly_discount' => $data['yearly_discount'],
            'category_id' => $data['category_id'],
            'fuel_id' => $data['fuel_id'],
            'brand_id' => $data['brand_id'],
            'model_id' => $data['model_id'],
            'model_year_id' => $data['model_year_id'],
            'transmission_id' => $data['transmission_id'],
            'branch_id' => $data['branch_id'],
            'airport_transfer_service' => $data['airport_transfer_service'],
            'airport_transfer_service_price' => $data['airport_transfer_service_price'],
            'deliver_to_my_location' => $data['deliver_to_my_location'],
            'deliver_to_my_location_price' => $data['deliver_to_my_location_price'],
            'daily_after_discount'=> $data['daily'] - ( $data['daily'] * ($data['daily_discount']/100) ),
            'weekly_after_discount'=> $data['weekly'] - ( $data['weekly'] * ($data['weekly_discount']/100) ),
            'monthly_after_discount'=> $data['monthly'] - ( $data['monthly'] * ($data['monthly_discount']/100) ),
            'yearly_after_discount'=> $data['yearly'] - ( $data['yearly'] * ($data['yearly_discount']/100) ),

        ];

        $car = $this->car->create($carData);
        
        if(is_array($data['Images']) && count($data['Images']) > 0){
            foreach ($data['Images'] as $image) {
                $this->carImages->create([
                    'image' => $image,
                    'car_id' => $car->uuid
                ]);
            }
        }
        
        if(is_array($data['Features']) && count($data['Features']) > 0){
            foreach ($data['Features'] as $feature) {
                $this->carFeatures->create([
                    'feature_id' => $feature,
                    'car_id' => $car->uuid
                ]);
            }
        }
        if(is_array($data['AdditionalFeatures']) && count($data['AdditionalFeatures']) > 0){
            foreach ($data['AdditionalFeatures'] as $additionalFeature) {
                $this->carAdditionalFeatures->create([
                    'name_en' => $additionalFeature['name_en'],
                    'name_ar' => $additionalFeature['name_ar'],
                    'price' => $additionalFeature['price'],
                    'car_id' => $car->uuid
                ]);
            }
        }

        if(is_array($data['Colors']) && count($data['Colors']) > 0){
            foreach ($data['Colors'] as $color) {
                $this->carHasColors->create([
                    'total' => $color['total'],
                    'color_id' => $color['color_id'],
                    'car_id' => $car->uuid
                ]);
            }
        }


        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Add Car Operation Success' : $message = 'نجحت عملية اضافة السيارة';

        return Helper::ResponseData(null,$message,true,200);


        

    }

    public function Update($data = []){ 
        
        if(Auth::guard('dashboard')->user()->role == 'Branch Manager' || Auth::guard('dashboard')->user()->role == 'Branch Employee'){
            $car = $this->car->where('uuid',$data['id'])->whereHas('Branch',function(Builder $query){
                $query->where('uuid',Auth::guard('dashboard')->user()->branch_id);
            })->first();
        }else{
            $car = $this->car->where('uuid',$data['id'])->first();
        }
        if(!$car){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Car Not Found' : $message = 'السيارة غير موجودة';
            return Helper::ResponseData(null,$message,false,404);
        }
        
        $category = $this->category->where('uuid',$data['category_id'])->first();
        if(!$category){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Category Not Found' : $message = 'قسم غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $fuelType = $this->fuelType->where('uuid',$data['fuel_id'])->first();
        if(!$fuelType){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Fuel Type Not Found' : $message = 'نوع الوقود غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $brand = $this->brand->where('uuid',$data['brand_id'])->first();
        if(!$brand){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Brand Not Found' : $message = 'الماركة غير موجودة';
            return Helper::ResponseData(null,$message,false,404);
        }

        $model = $this->model->where('uuid',$data['model_id'])->first();
        if(!$model){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Model Not Found' : $message = 'الطراز غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $modelYear = $this->modelYear->where('uuid',$data['model_year_id'])->first();
        if(!$modelYear){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Model Year Not Found' : $message = 'سنة الصنع غير موجودة';
            return Helper::ResponseData(null,$message,false,404);
        }

        $transmission = $this->transmission->where('uuid',$data['transmission_id'])->first();
        if(!$transmission){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Transmission Not Found' : $message = 'ناقل الحركة غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $branch = $this->branch->where('uuid',$data['branch_id'])->first();
        if(!$branch){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Branch Not Found' : $message = 'فرع غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $carData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
            'description_en' => $data['description_en'],
            'description_ar' => $data['description_ar'],
            'description_two_en' => $data['description_two_en'],
            'description_two_ar' => $data['description_two_ar'],
            'bags' => $data['bags'],
            'passengers' => $data['passengers'],
            'doors' => $data['doors'],
            'daily' => $data['daily'],
            'daily_discount' => $data['daily_discount'],
            'weekly' => $data['weekly'],
            'weekly_discount' => $data['weekly_discount'],
            'monthly' => $data['monthly'],
            'monthly_discount' => $data['monthly_discount'],
            'yearly' => $data['yearly'],
            'yearly_discount' => $data['yearly_discount'],
            'category_id' => $data['category_id'],
            'fuel_id' => $data['fuel_id'],
            'brand_id' => $data['brand_id'],
            'model_id' => $data['model_id'],
            'model_year_id' => $data['model_year_id'],
            'transmission_id' => $data['transmission_id'],
            'branch_id' => $data['branch_id'],
            'airport_transfer_service' => $data['airport_transfer_service'],
            'airport_transfer_service_price' => $data['airport_transfer_service_price'],
            'deliver_to_my_location' => $data['deliver_to_my_location'],
            'deliver_to_my_location_price' => $data['deliver_to_my_location_price'],
            'daily_after_discount'=> $data['daily'] - ( $data['daily'] * ($data['daily_discount']/100) ),
            'weekly_after_discount'=> $data['weekly'] - ( $data['weekly'] * ($data['weekly_discount']/100) ),
            'monthly_after_discount'=> $data['monthly'] - ( $data['monthly'] * ($data['monthly_discount']/100) ),
            'yearly_after_discount'=> $data['yearly'] - ( $data['yearly'] * ($data['yearly_discount']/100) ),
        ];

        $car->update($carData);
        
        foreach ($car->Images as $image) {
            $image->delete();
        }
        foreach ($car->Features as $feature) {
            $feature->delete();
        }
        foreach ($car->AdditionalFeatures as $additionalFeature) {
            $additionalFeature->delete();
        }
        foreach ($car->Colors as $color) {
            $color->delete();
        }

        if(is_array($data['Images']) && count($data['Images']) > 0){
            foreach ($data['Images'] as $image) {
                $this->carImages->create([
                    'image' => $image,
                    'car_id' => $car->uuid
                ]);
            }
        }
        
        if(is_array($data['Features']) && count($data['Features']) > 0){
            foreach ($data['Features'] as $feature) {
                $this->carFeatures->create([
                    'feature_id' => $feature,
                    'car_id' => $car->uuid
                ]);
            }
        }
        if(is_array($data['AdditionalFeatures']) && count($data['AdditionalFeatures']) > 0){
            foreach ($data['AdditionalFeatures'] as $additionalFeature) {
                $this->carAdditionalFeatures->create([
                    'name_en' => $additionalFeature['name_en'],
                    'name_ar' => $additionalFeature['name_ar'],
                    'price' => $additionalFeature['price'],
                    'car_id' => $car->uuid
                ]);
            }
        }

        if(is_array($data['Colors']) && count($data['Colors']) > 0){
            foreach ($data['Colors'] as $color) {
                $this->carHasColors->create([
                    'total' => $color['total'],
                    'color_id' => $color['color_id'],
                    'car_id' => $car->uuid
                ]);
            }
        }


        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Update Car information Operation Success' : $message = 'نجحت عملية تعديل بيانات السيارة';

        return Helper::ResponseData(null,$message,true,200);


        

    }
    
    public function Delete($id){   
        
        if(Auth::guard('dashboard')->user()->role == 'Branch Manager' || Auth::guard('dashboard')->user()->role == 'Branch Employee'){
            $car = $this->car->where('uuid',$id)->whereHas('Branch',function(Builder $query){
                $query->where('uuid',Auth::guard('dashboard')->user()->branch_id);
            })->first();
        }else{
            $car = $this->car->where('uuid',$id)->first();
        }
        if(!$car){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Car Not Found' : $message = 'السيارة غير موجودة';
            return Helper::ResponseData(null,$message,false,404);
        }


        $car->forceDelete();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Delete Car Operation Success' : $message = 'نجحت عملية حذف السيارة';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    public function Active($id){   
        
        if(Auth::guard('dashboard')->user()->role == 'Branch Manager' || Auth::guard('dashboard')->user()->role == 'Branch Employee'){
            $car = $this->car->where('uuid',$id)->whereHas('Branch',function(Builder $query){
                $query->where('uuid',Auth::guard('dashboard')->user()->branch_id);
            })->first();
        }else{
            $car = $this->car->where('uuid',$id)->first();
        }
        if(!$car){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Car Not Found' : $message = 'السيارة غير موجودة';
            return Helper::ResponseData(null,$message,false,404);
        }

        if($car->active == true){
            if($car->Branch->active == false){
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = 'Car branch is inactive' : $message = 'فرع السيارة غير نشط';
                return Helper::ResponseData(null,$message,false,400);
            }
            $car->update([
                'active' => false
            ]);
        }
        else{
            $car->update([
                'active' => true
            ]);
        }

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Change Car Status Operation Success' : $message = 'نجحت عملية تعديل حالة السيارة';

        return Helper::ResponseData(null,$message,true,200);

        

    }


   

                    
}