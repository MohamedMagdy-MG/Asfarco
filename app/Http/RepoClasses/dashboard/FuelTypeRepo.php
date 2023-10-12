<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\FuelTypeInterface;
use App\Http\Resources\dashboard\FuelTypeResource;
use App\Models\FuelType;
use Illuminate\Database\Eloquent\Builder;

class FuelTypeRepo implements FuelTypeInterface
{
       
    public $FuelType;
    public function __construct()
    {
        $this->FuelType = new FuelType();
    }

   
    public function getAllFuelTypes($search){
        
        $FuelTypees = $this->FuelType;
        
        if($search != null){
            $FuelTypees = $FuelTypees->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%');
            });
            
        }
        
        $FuelTypees = $FuelTypees->latest()->paginate(10);
        $data = [
            'FuelTypees' => FuelTypeResource::collection($FuelTypees),
            'Pagination' => [
                'total'       => $FuelTypees->total(),
                'count'       => $FuelTypees->count(),
                'perPage'     => $FuelTypees->perPage(),
                'currentPage' => $FuelTypees->currentPage(),
                'totalPages'  => $FuelTypees->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Cars Fuel Types Operation Success' : $message = 'نجحت عملية الحصول علي كل انواع وقود السيارات ';

        return Helper::ResponseData($data,$message,true,200);
    }


    public function Add($data = []){ 


        $FuelTypeData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
        ];
        $this->FuelType->create($FuelTypeData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Add Cars Fuel Type Operation Success' : $message = 'نجحت عملية اضافة نوع وقود السيارات';

        return Helper::ResponseData(null,$message,true,200);


        

    }


    public function Update($data = []){ 

        $FuelType = $this->FuelType->where('uuid',$data['id'])->first();
        if(!$FuelType){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Cars Fuel Type Not Found' : $message = 'نوع وقود السيارات غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }


        $FuelTypeData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],  
        ];
        $FuelType->update($FuelTypeData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Edit Cars Fuel Type Information Operation Success' : $message = 'نجحت عملية تعديل بيانات نوع وقود السيارات';

        return Helper::ResponseData(null,$message,true,200);


        

    }

   
    public function Delete($id){   
        
        $FuelType = $this->FuelType->where('uuid',$id)->first();
        if(!$FuelType){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Cars Fuel Type Not Found' : $message = 'نوع وقود السيارات غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $FuelType->delete();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Delete Cars Fuel Type Operation Success' : $message = 'نجحت عملية حذف نوع وقود السيارات';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    

    

                    
}