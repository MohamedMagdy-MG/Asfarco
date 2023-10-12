<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\TransmissionInterface;
use App\Http\Resources\dashboard\TransmissionResource;
use App\Models\Transmission;
use Illuminate\Database\Eloquent\Builder;

class TransmissionRepo implements TransmissionInterface
{
       
    public $Transmission;
    public function __construct()
    {
        $this->Transmission = new Transmission();
    }

   
    public function getAllTransmissions($search){
        
        $Transmissiones = $this->Transmission;
        
        if($search != null){
            $Transmissiones = $Transmissiones->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%');
            });
            
        }
        
        $Transmissiones = $Transmissiones->latest()->paginate(10);
        $data = [
            'Transmissiones' => TransmissionResource::collection($Transmissiones),
            'Pagination' => [
                'total'       => $Transmissiones->total(),
                'count'       => $Transmissiones->count(),
                'perPage'     => $Transmissiones->perPage(),
                'currentPage' => $Transmissiones->currentPage(),
                'totalPages'  => $Transmissiones->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Cars Transmissions Operation Success' : $message = 'نجحت عملية الحصول علي كل انتقالات السيارات ';

        return Helper::ResponseData($data,$message,true,200);
    }


    public function Add($data = []){ 


        $TransmissionData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
        ];
        $this->Transmission->create($TransmissionData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Add Cars Transmission Operation Success' : $message = 'نجحت عملية اضافة انتقال السيارات';

        return Helper::ResponseData(null,$message,true,200);


        

    }


    public function Update($data = []){ 

        $Transmission = $this->Transmission->where('uuid',$data['id'])->first();
        if(!$Transmission){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Cars Transmission Not Found' : $message = 'انتقال السيارات غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }


        $TransmissionData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],  
        ];
        $Transmission->update($TransmissionData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Edit Cars Transmission Information Operation Success' : $message = 'نجحت عملية تعديل بيانات انتقال السيارات';

        return Helper::ResponseData(null,$message,true,200);


        

    }

   
    public function Delete($id){   
        
        $Transmission = $this->Transmission->where('uuid',$id)->first();
        if(!$Transmission){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Cars Transmission Not Found' : $message = 'انتقال السيارات غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $Transmission->delete();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Delete Cars Transmission Operation Success' : $message = 'نجحت عملية حذف انتقال السيارات';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    

    

                    
}