<?php
        
namespace App\Http\RepoClasses\mobile;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\mobile\HomeInterface;
use App\Http\Resources\mobile\CarCategoryResource;
use App\Http\Resources\mobile\CarDetailsResource;
use App\Http\Resources\mobile\CarResource;
use App\Http\Resources\mobile\CustomCarResources\CarBrandCustomResource;
use App\Http\Resources\mobile\CustomCarResources\CarColorCustomResource;
use App\Http\Resources\mobile\CustomCarResources\CarModelCustomResource;
use App\Http\Resources\mobile\CustomCarResources\FeatureCustomResource;
use App\Http\Resources\mobile\CustomCarResources\FuelTypeCustomResource;
use App\Http\Resources\mobile\CustomCarResources\ModelYearResource;
use App\Http\Resources\mobile\CustomCarResources\TransmissionCustomResource;
use App\Http\Resources\mobile\filter\CarCategoryFilterResource;
use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarCategory;
use App\Models\CarColor;
use App\Models\CarModel;
use App\Models\Feature;
use App\Models\FuelType;
use App\Models\ModelYear;
use App\Models\Transmission;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class HomeRepo implements HomeInterface
{
    public $carCategory;
    public $car;

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
        $this->carCategory = new CarCategory();
        $this->fuelType = new FuelType();
        $this->brand = new CarBrand();
        $this->model = new CarModel();
        $this->modelYear = new ModelYear();
        $this->transmission = new Transmission();
        $this->feature = new Feature();
        $this->color = new CarColor();
    }
    public function getAllCategories(){
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'ar' ? $carCategory = $this->carCategory->whereHas('Cars',function(Builder $query){
            $query->where('active',true);
        })->orderBy('name_ar','asc')->get() : $carCategory = $this->carCategory->whereHas('Cars',function(Builder $query){
            $query->where('active',true);
        })->orderBy('name_en','asc')->get();
        $language == 'en' ? $message = 'The process succeeded in reaching all categories of cars' : $message = 'نجحت العملية في الوصول إلى جميع فئات السيارات ';

        return Helper::ResponseData(CarCategoryResource::collection($carCategory),$message,true,200);
    }
    public function getAllHomePageCars(){
        
        $car = $this->car->where('active',true)->latest()->take(6)->get();
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The operation succeeded in reaching all cars of the home page' : $message = 'نجحت العملية في الوصول إلى جميع سيارات الصفحة الرئيسية ';

        return Helper::ResponseData(CarResource::collection($car),$message,true,200);
    }
    public function getAllCategoriesWithID(){
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'ar' ? $carCategory = $this->carCategory->whereHas('Cars',function(Builder $query){
            $query->where('active',true);
        })->orderBy('name_ar','asc')->get() : $carCategory = $this->carCategory->whereHas('Cars',function(Builder $query){
            $query->where('active',true);
        })->orderBy('name_en','asc')->get();
        $language == 'en' ? $message = 'The process succeeded in reaching all categories of cars' : $message = 'نجحت العملية في الوصول إلى جميع فئات السيارات ';

        return Helper::ResponseData(CarCategoryFilterResource::collection($carCategory),$message,true,200);
    }
    public function getAllFuelTypes(){
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'ar' ? $fuelType = $this->fuelType->whereHas('Cars',function(Builder $query){
            $query->where('active',true);
        })->orderBy('name_ar','asc')->get() : $fuelType = $this->fuelType->whereHas('Cars',function(Builder $query){
            $query->where('active',true);
        })->orderBy('name_en','asc')->get();
        $language == 'en' ? $message = 'The process succeeded in reaching all types of fuel in cars' : $message = 'نجحت العملية في الوصول إلى جميع أنواع الوقود في السيارات ';
        return Helper::ResponseData(FuelTypeCustomResource::collection($fuelType),$message,true,200);
    }
    public function getAllBrands(){
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'ar' ? $brand = $this->brand->whereHas('Cars',function(Builder $query){
            $query->where('active',true);
        })->orderBy('name_ar','asc')->get() : $brand = $this->brand->whereHas('Cars',function(Builder $query){
            $query->where('active',true);
        })->orderBy('name_en','asc')->get();
        $language == 'en' ? $message = 'The process succeeded in reaching all car brands' : $message = 'نجحت العملية في الوصول إلى جميع ماركات السيارات ';
        return Helper::ResponseData(CarBrandCustomResource::collection($brand),$message,true,200);
    }
    public function getAllModels($brand){
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';

        if($brand != null){
            $language == 'ar' ? $model = $this->model->whereHas('Cars',function(Builder $query){
            $query->where('active',true);
        })->where('car_brand_id',$brand)->orderBy('name_ar','asc')->get() : $model = $this->model->whereHas('Cars',function(Builder $query){
            $query->where('active',true);
        })->where('car_brand_id',$brand)->orderBy('name_en','asc')->get();
        }
        else{
            $language == 'ar' ? $model = $this->model->whereHas('Cars',function(Builder $query){
            $query->where('active',true);
        })->orderBy('name_ar','asc')->get() : $model = $this->model->whereHas('Cars',function(Builder $query){
            $query->where('active',true);
        })->orderBy('name_en','asc')->get();

        }
        $language == 'en' ? $message = 'The process succeeded in reaching all car models' : $message = 'نجحت العملية في الوصول إلى جميع موديلات السيارات ';
        return Helper::ResponseData(CarModelCustomResource::collection($model),$message,true,200);
    }
    public function getAllModelYears(){
        $modelYear = $this->modelYear->whereHas('Cars',function(Builder $query){
            $query->where('active',true);
        })->orderBy('year','asc')->get();
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The process has been successful in all car model years' : $message = 'نجحت العملية في الوصول إلى جميع سنوات موديلات السيارات ';
        return Helper::ResponseData(ModelYearResource::collection($modelYear),$message,true,200);
    }
    public function getAllTransmissions(){
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'ar' ? $transmission = $this->transmission->whereHas('Cars',function(Builder $query){
            $query->where('active',true);
        })->orderBy('name_ar','asc')->get() : $transmission = $this->transmission->whereHas('Cars',function(Builder $query){
            $query->where('active',true);
        })->orderBy('name_en','asc')->get();
        $language == 'en' ? $message = 'The operation succeeded in reaching the transmission of all cars' : $message = 'ونجحت العملية في الوصول إلى ناقل الحركة في جميع السيارات ';
        return Helper::ResponseData(TransmissionCustomResource::collection($transmission),$message,true,200);
    }
    public function getAllFeatures(){
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'ar' ? $feature = $this->feature->whereHas('CarFeature',function(Builder $query){
            $query->whereHas('Car',function(Builder $query){
                $query->where('active',true);
            });
        })->orderBy('name_ar','asc')->get() : $feature = $this->feature->whereHas('CarFeature',function(Builder $query){
            $query->whereHas('Car',function(Builder $query){
                $query->where('active',true);
            });
        })->orderBy('name_en','asc')->get();
        $language == 'en' ? $message = 'The process succeeded in achieving all the features of the cars' : $message = 'نجحت العملية في الوصول إلى كافة مميزات السيارات ';
        return Helper::ResponseData(FeatureCustomResource::collection($feature),$message,true,200);
    }
    public function getAllColors(){
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'ar' ? $color = $this->color->whereHas('CarHasColors',function(Builder $query){
            $query->whereHas('Car',function(Builder $query){
                $query->where('active',true);
            });
        })->orderBy('name_ar','asc')->get() : $color = $this->color->whereHas('CarHasColors',function(Builder $query){
            $query->whereHas('Car',function(Builder $query){
                $query->where('active',true);
            });
        })->orderBy('name_en','asc')->get();
        $language == 'en' ? $message = 'The process succeeded in reaching all colors of cars' : $message = 'نجحت العملية في الوصول إلى كافة الوان السيارات ';
        return Helper::ResponseData(CarColorCustomResource::collection($color),$message,true,200);
    }
    public function getAllCars($id,$price,$brand,$model,$year,$category,$color,$fuel_type,$features,$passengers,$luggae,$transmission){
        if($id != null){
            $car = $this->car->where('uuid',$id)->first();
            if(!$car){
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = 'Car Not Found' : $message = 'لم يتم العثور على السيارة';
                return Helper::ResponseData(null,$message,false,404);
            }
    
    
    
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = "The operation succeeded in accessing the car's data" : $message = 'نجحت العملية في الوصول إلى بيانات السيارة';
    
            return Helper::ResponseData(new CarDetailsResource($car),$message,true,200);
    
            
        }
        else{
            $car = $this->car;
            if($price != null){
                $car = $car->where(function(Builder $query) use($price){
                    $query->whereBetween('daily_after_discount',$price)->orWhereBetween('weekly_after_discount',$price)->orWhereBetween('monthly_after_discount',$price);
                   
                });
            }
            if($passengers != null){
                $car = $car->where(function(Builder $query) use($passengers){
                    $query->whereBetween('passengers',$passengers);
                   
                });
            }
            if($luggae != null){
                $car = $car->where(function(Builder $query) use($luggae){
                    $query->whereBetween('bags',$luggae);
                   
                });
            }
            if($brand != null){
                $car = $car->where(function(Builder $query) use($brand){
                    $query->whereHas('Brand',function(Builder $query) use($brand){
                        $query->whereIn('uuid',$brand);
                    });
                   
                });
                
            }
            if($model != null){
                $car = $car->where(function(Builder $query) use($model){
                    $query->whereHas('Model',function(Builder $query) use($model){
                        $query->whereIn('uuid',$model);
                    });
                   
                });
                
            }
    
            if($year != null){
                $car = $car->where(function(Builder $query) use($year){
                    $query->whereHas('ModelYear',function(Builder $query) use($year){
                        $query->whereIn('uuid',$year);
                    });
                   
                });
                
            }
    
            if($category != null){
                $car = $car->where(function(Builder $query) use($category){
                    $query->whereHas('Category',function(Builder $query) use($category){
                        $query->whereIn('uuid',$category);
                    });
                   
                });
                
            }

            if($transmission != null){
                $car = $car->where(function(Builder $query) use($transmission){
                    $query->whereHas('Transmission',function(Builder $query) use($transmission){
                        $query->whereIn('uuid',$transmission);
                    });
                   
                });
                
            }
    
            if($fuel_type != null){
                $car = $car->where(function(Builder $query) use($fuel_type){
                    $query->whereHas('FuelType',function(Builder $query) use($fuel_type){
                        $query->whereIn('uuid',$fuel_type);
                    });
                   
                });
                
            }
    
            if($color != null){
                $car = $car->where(function(Builder $query) use($color){
                    $query->whereHas('Colors',function(Builder $query) use($color){
                        $query->whereHas('Color',function(Builder $query) use($color){
                            $query->whereIn('uuid',$color);
                        });
                    });
                   
                });
                
            }
    
            if($features != null){
                $car = $car->where(function(Builder $query) use($features){
                    $query->whereHas('AdditionalFeatures',function(Builder $query) use($features){
                        $query->whereIn('uuid',$features);
                    });
                   
                });
                
            }
           
            
            $car = $car->latest()->paginate(4);
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
            $language == 'en' ? $message = 'The operation succeeded in reaching all cars' : $message = 'نجحت العملية في الوصول إلى جميع السيارات';
    
            return Helper::ResponseData($data,$message,true,200);
        }
        
    }
    public function getAllCarDetailsPageCars(){
        
        $car = $this->car->where('active',true)->latest()->take(6)->get();
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The process successfully reached all cars on the car details page.' : $message = 'نجحت العملية في الوصول إلى جميع السيارات الموجودة في صفحة تفاصيل السيارة ';

        return Helper::ResponseData(CarResource::collection($car),$message,true,200);
    }
    public function getAllAboutUsPageCars(){
        
        $car = $this->car->where('active',true)->latest()->take(6)->get();
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The process successfully reached all cars on the About Us page.' : $message = 'نجحت العملية في الوصول إلى جميع السيارات الموجودة في صفحة نبذة عنا.';

        return Helper::ResponseData(CarResource::collection($car),$message,true,200);
    }
    public function getAllSavedCarsPageCars(){
        
        $car = $this->car->where('active',true)->latest()->take(6)->get();
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'The process succeeded in accessing all the cars on the Saved Cars page' : $message = 'نجحت العملية في الوصول إلى كافة السيارات الموجودة في صفحة السيارات المحفوظة ';

        return Helper::ResponseData(CarResource::collection($car),$message,true,200);
    }


    
        
                    
}