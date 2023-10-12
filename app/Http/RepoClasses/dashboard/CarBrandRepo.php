<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\CarBrandInterface;
use App\Http\Resources\dashboard\CarBrandResource;
use App\Models\CarBrand;
use Illuminate\Database\Eloquent\Builder;

class CarBrandRepo implements CarBrandInterface
{
       
    public $carBrand;
    public function __construct()
    {
        $this->carBrand = new CarBrand();
    }

   
    public function getAllCarBrands($search){
        
        $carBrandes = $this->carBrand;
        
        if($search != null || $search != ''){
            $carBrandes = $carBrandes->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%');
            });
            
        }
        
        $carBrandes = $carBrandes->latest()->paginate(10);
        $data = [
            'carBrandes' => CarBrandResource::collection($carBrandes),
            'Pagination' => [
                'total'       => $carBrandes->total(),
                'count'       => $carBrandes->count(),
                'perPage'     => $carBrandes->perPage(),
                'currentPage' => $carBrandes->currentPage(),
                'totalPages'  => $carBrandes->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Car Brandes Operation Success' : $message = 'نجحت عملية الحصول علي كل ماركات السيارات ';

        return Helper::ResponseData($data,$message,true,200);
    }


    public function Add($data = []){ 


        $carBrandData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
            'image' => $data['image']       
        ];
        $this->carBrand->create($carBrandData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Add Car Brand Operation Success' : $message = 'نجحت عملية اضافة ماركة السيارة';

        return Helper::ResponseData(null,$message,true,200);


        

    }


    public function Update($data = []){ 

        $carBrand = $this->carBrand->where('uuid',$data['id'])->first();
        if(!$carBrand){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Car Brand Not Found' : $message = 'ماركة السيارة غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }


        $carBrandData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],   
            'image' => $data['image']               
        ];
        $carBrand->update($carBrandData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Edit Car Brand Information Operation Success' : $message = 'نجحت عملية تعديل بيانات ماركة السيارة';

        return Helper::ResponseData(null,$message,true,200);


        

    }

   
    public function Delete($id){   
        
        $carBrand = $this->carBrand->where('uuid',$id)->first();
        if(!$carBrand){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Car Brand Not Found' : $message = 'ماركة السيارة غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $carBrand->delete();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Delete Car Brand Operation Success' : $message = 'نجحت عملية حذف ماركة السيارة';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    

    

                    
}