<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\CarColorInterface;
use App\Http\Resources\dashboard\CarColorResource;
use App\Models\CarColor;
use Illuminate\Database\Eloquent\Builder;

class CarColorRepo implements CarColorInterface
{
       
    public $carColor;
    public function __construct()
    {
        $this->carColor = new CarColor();
    }

   
    public function getAllCarColors($search){
        
        $carColores = $this->carColor;
        
        if($search != null){
            $carColores = $carColores->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%');
            });
            
        }
        
        $carColores = $carColores->latest()->paginate(10);
        $data = [
            'carColores' => CarColorResource::collection($carColores),
            'Pagination' => [
                'total'       => $carColores->total(),
                'count'       => $carColores->count(),
                'perPage'     => $carColores->perPage(),
                'currentPage' => $carColores->currentPage(),
                'totalPages'  => $carColores->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Cars Colors Operation Success' : $message = 'نجحت عملية الحصول علي كل الوان السيارات ';

        return Helper::ResponseData($data,$message,true,200);
    }


    public function Add($data = []){ 


        $carColorData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
            'hexa_code' => $data['hexa_code']
        ];
        $this->carColor->create($carColorData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Add Cars Color Operation Success' : $message = 'نجحت عملية اضافة لون السيارات';

        return Helper::ResponseData(null,$message,true,200);


        

    }


    public function Update($data = []){ 

        $carColor = $this->carColor->where('uuid',$data['id'])->first();
        if(!$carColor){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Cars Color Not Found' : $message = 'لون السيارات غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }


        $carColorData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],  
            'hexa_code' => $data['hexa_code'] 
        ];
        $carColor->update($carColorData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Edit Cars Color Information Operation Success' : $message = 'نجحت عملية تعديل بيانات لون السيارات';

        return Helper::ResponseData(null,$message,true,200);


        

    }

   
    public function Delete($id){   
        
        $carColor = $this->carColor->where('uuid',$id)->first();
        if(!$carColor){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Cars Color Not Found' : $message = 'لون السيارات غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $carColor->delete();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Delete Cars Color Operation Success' : $message = 'نجحت عملية حذف لون السيارات';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    

    

                    
}