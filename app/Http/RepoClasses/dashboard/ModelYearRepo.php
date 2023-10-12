<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\ModelYearInterface;
use App\Http\Resources\dashboard\ModelYearResource;
use App\Models\ModelYear;
use Illuminate\Database\Eloquent\Builder;

class ModelYearRepo implements ModelYearInterface
{
       
    public $modelYear;
    public function __construct()
    {
        $this->modelYear = new ModelYear();
    }

   
    public function getAllModelYears($search){
        
        $modelYeares = $this->modelYear;
        
        if($search != null){
            $modelYeares = $modelYeares->where(function(Builder $query) use($search){
                $query->where('year','LIKE','%'.$search.'%');
            });
            
        }
        
        $modelYeares = $modelYeares->latest()->paginate(10);
        $data = [
            'modelYeares' => ModelYearResource::collection($modelYeares),
            'Pagination' => [
                'total'       => $modelYeares->total(),
                'count'       => $modelYeares->count(),
                'perPage'     => $modelYeares->perPage(),
                'currentPage' => $modelYeares->currentPage(),
                'totalPages'  => $modelYeares->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Cars Models Years Operation Success' : $message = 'نجحت عملية الحصول علي كل سنين صنع السيارات ';

        return Helper::ResponseData($data,$message,true,200);
    }


    public function Add($data = []){ 


        $modelYearData = [
            'year' => $data['year'],
           
        ];
        $this->modelYear->create($modelYearData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Add Cars Model Year  Operation Success' : $message = 'نجحت عملية اضافة سنة الصنع السيارات';

        return Helper::ResponseData(null,$message,true,200);


        

    }


    public function Update($data = []){ 

        $modelYear = $this->modelYear->where('uuid',$data['id'])->first();
        if(!$modelYear){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Cars Model Year  Not Found' : $message = 'سنة الصنع السيارات غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }


        $modelYearData = [
            'year' => $data['year'],
        ];
        $modelYear->update($modelYearData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Edit Cars Model Year  Information Operation Success' : $message = 'نجحت عملية تعديل بيانات سنة الصنع السيارات';

        return Helper::ResponseData(null,$message,true,200);


        

    }

   
    public function Delete($id){   
        
        $modelYear = $this->modelYear->where('uuid',$id)->first();
        if(!$modelYear){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Cars Model Year  Not Found' : $message = 'سنة الصنع السيارات غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $modelYear->delete();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Delete Cars Model Year  Operation Success' : $message = 'نجحت عملية حذف سنة الصنع السيارات';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    

    

                    
}