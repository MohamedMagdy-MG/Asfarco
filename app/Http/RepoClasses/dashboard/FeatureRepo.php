<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\FeatureInterface;
use App\Http\Resources\dashboard\FeatureResource;
use App\Models\Feature;
use Illuminate\Database\Eloquent\Builder;

class FeatureRepo implements FeatureInterface
{
       
    public $feature;
    public function __construct()
    {
        $this->feature = new Feature();
    }

   
    public function getAllFeaturees($search){
        
        $featurees = $this->feature;
        
        if($search != null){
            $featurees = $featurees->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%');
            });
            
        }
        
        $featurees = $featurees->latest()->paginate(10);
        $data = [
            'featurees' => FeatureResource::collection($featurees),
            'Pagination' => [
                'total'       => $featurees->total(),
                'count'       => $featurees->count(),
                'perPage'     => $featurees->perPage(),
                'currentPage' => $featurees->currentPage(),
                'totalPages'  => $featurees->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Featurees Operation Success' : $message = 'نجحت عملية الحصول علي كل الخدمات ';

        return Helper::ResponseData($data,$message,true,200);
    }


    public function Add($data = []){ 


        $featureData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
        ];
        $this->feature->create($featureData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Add feature Operation Success' : $message = 'نجحت عملية اضافة الخدمة';

        return Helper::ResponseData(null,$message,true,200);


        

    }


    public function Update($data = []){ 

        $feature = $this->feature->where('uuid',$data['id'])->first();
        if(!$feature){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' feature Not Found' : $message = 'الخدمة غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }


        $featureData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],    
        ];
        $feature->update($featureData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Edit feature Information Operation Success' : $message = 'نجحت عملية تعديل بيانات الخدمة';

        return Helper::ResponseData(null,$message,true,200);


        

    }

   
    public function Delete($id){   
        
        $feature = $this->feature->where('uuid',$id)->first();
        if(!$feature){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' feature Not Found' : $message = 'الخدمة غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $feature->delete();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Delete feature Operation Success' : $message = 'نجحت عملية حذف الخدمة';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    

    

                    
}