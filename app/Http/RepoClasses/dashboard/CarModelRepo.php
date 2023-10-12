<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\CarModelInterface;
use App\Http\Resources\dashboard\CarBrandCustomResource;
use App\Http\Resources\dashboard\CarModelResource;
use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Database\Eloquent\Builder;

class CarModelRepo implements CarModelInterface
{
       
    public $carModel;
    public $carBrand;
    public function __construct()
    {
        $this->carModel = new CarModel();
        $this->carBrand = new CarBrand();
    }

   
    public function getAllCarModels($search){
        
        $carModeles = $this->carModel;
        
        if($search != null){
            $carModeles = $carModeles->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%')
                ->orWhereHas('Brand',function(Builder $query) use($search){
                    $query->where('name_en','LIKE','%'.$search.'%')
                    ->orWhere('name_ar','LIKE','%'.$search.'%');
                });
            });
            
        }
        
        $carModeles = $carModeles->latest()->paginate(10);
        $data = [
            'carModeles' => CarModelResource::collection($carModeles),
            'Pagination' => [
                'total'       => $carModeles->total(),
                'count'       => $carModeles->count(),
                'perPage'     => $carModeles->perPage(),
                'currentPage' => $carModeles->currentPage(),
                'totalPages'  => $carModeles->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Car Models Operation Success' : $message = 'نجحت عملية الحصول علي كل طرازات السيارات ';

        return Helper::ResponseData($data,$message,true,200);
    }
    public function getAllCarBrands(){
        
        $carBrand = $this->carBrand->latest()->get();
     
       
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Car Brandes Operation Success' : $message = 'نجحت عملية الحصول علي كل ماركات السيارات ';

        return Helper::ResponseData(CarBrandCustomResource::collection($carBrand),$message,true,200);
    }


    public function Add($data = []){ 

        $carBrand = $this->carBrand->where('uuid',$data['car_brand_id'])->first();
        if(!$carBrand){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Car Brand Not Found' : $message = 'ماركة السيارة غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $carModelData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
            'car_brand_id' => $data['car_brand_id']       
        ];
        $this->carModel->create($carModelData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Add Car Brand Operation Success' : $message = 'نجحت عملية اضافة طراز السيارة';

        return Helper::ResponseData(null,$message,true,200);


        

    }


    public function Update($data = []){ 

        $carModel = $this->carModel->where('uuid',$data['id'])->first();
        if(!$carModel){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Car Model Not Found' : $message = 'طراز السيارة غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $carBrand = $this->carBrand->where('uuid',$data['car_brand_id'])->first();
        if(!$carBrand){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Car Brand Not Found' : $message = 'ماركة السيارة غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }



        $carModelData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],   
            'car_brand_id' => $data['car_brand_id']      
        ];
        $carModel->update($carModelData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Edit Car Model Information Operation Success' : $message = 'نجحت عملية تعديل بيانات طراز السيارة';
        return Helper::ResponseData(null,$message,true,200);


        

    }

   
    public function Delete($id){   
        
        $carModel = $this->carModel->where('uuid',$id)->first();
        if(!$carModel){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Car Model Not Found' : $message = 'طراز السيارة غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $carModel->delete();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Delete Car Model Operation Success' : $message = 'نجحت عملية حذف طراز السيارة';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    

    

                    
}