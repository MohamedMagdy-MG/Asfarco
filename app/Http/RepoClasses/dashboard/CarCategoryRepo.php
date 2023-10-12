<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\CarCategoryInterface;
use App\Http\Resources\dashboard\CarCategoryResource;
use App\Models\CarCategory;
use Illuminate\Database\Eloquent\Builder;

class CarCategoryRepo implements CarCategoryInterface
{
       
    public $carCategory;
    public function __construct()
    {
        $this->carCategory = new CarCategory();
    }

   
    public function getAllCarCategories($search){
        
        $carCategoryes = $this->carCategory;
        
        if($search != null){
            $carCategoryes = $carCategoryes->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%');
            });
            
        }
        
        $carCategoryes = $carCategoryes->latest()->paginate(10);
        $data = [
            'carCategoryes' => CarCategoryResource::collection($carCategoryes),
            'Pagination' => [
                'total'       => $carCategoryes->total(),
                'count'       => $carCategoryes->count(),
                'perPage'     => $carCategoryes->perPage(),
                'currentPage' => $carCategoryes->currentPage(),
                'totalPages'  => $carCategoryes->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Cars Categories Operation Success' : $message = 'نجحت عملية الحصول علي كل أقسام السيارات ';

        return Helper::ResponseData($data,$message,true,200);
    }


    public function Add($data = []){ 


        $carCategoryData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
            'image' => $data['image'] 
        ];
        $this->carCategory->create($carCategoryData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Add Cars Category Operation Success' : $message = 'نجحت عملية اضافة قسم السيارات';

        return Helper::ResponseData(null,$message,true,200);


        

    }


    public function Update($data = []){ 

        $carCategory = $this->carCategory->where('uuid',$data['id'])->first();
        if(!$carCategory){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Cars Category Not Found' : $message = 'قسم السيارات غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }


        $carCategoryData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],  
            'image' => $data['image'] 
        ];
        $carCategory->update($carCategoryData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Edit Cars Category Information Operation Success' : $message = 'نجحت عملية تعديل بيانات قسم السيارات';

        return Helper::ResponseData(null,$message,true,200);


        

    }

   
    public function Delete($id){   
        
        $carCategory = $this->carCategory->where('uuid',$id)->first();
        if(!$carCategory){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Cars Category Not Found' : $message = 'قسم السيارات غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $carCategory->delete();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Delete Cars Category Operation Success' : $message = 'نجحت عملية حذف قسم السيارات';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    

    

                    
}