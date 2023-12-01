<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\BranchInterface;
use App\Http\Resources\dashboard\BranchResource;
use App\Http\Resources\dashboard\CityResource;
use App\Models\Branch;
use App\Models\City;
use Illuminate\Database\Eloquent\Builder;

class BranchRepo implements BranchInterface
{
       
    public $branch;
    public $cities;
    public function __construct()
    {
        $this->branch = new Branch();
        $this->cities = new City();
    }

    public function getAllCities(){
        
        $cities = $this->cities->get();
        
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All City Operation Success' : $message = 'نجحت عملية الحصول علي كل المحافظات ';

        return Helper::ResponseData(CityResource::collection($cities),$message,true,200);
    }
    public function getAllBranches($search,$city){
        
        $branches = $this->branch;
        
        if($search != null){
            $branches = $branches->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%')
                ->orWhere('gender',$search)
                ->orWhere('mobile',$search)
                ->orWhere('email',$search);
            });
            
        }
        if($city != null){
            $branches = $branches->where(function(Builder $query) use($city){
                $query->where('city_id',$city);
            });
            
        }
        
        $branches = $branches->latest()->paginate(10);
        $data = [
            'Branches' => BranchResource::collection($branches),
            'Pagination' => [
                'total'       => $branches->total(),
                'count'       => $branches->count(),
                'perPage'     => $branches->perPage(),
                'currentPage' => $branches->currentPage(),
                'totalPages'  => $branches->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Branches Operation Success' : $message = 'نجحت عملية الحصول علي كل الفروع ';

        return Helper::ResponseData($data,$message,true,200);
    }


    public function Add($data = []){ 

        $cities = $this->cities->where('id',$data['city_id'])->first();
        if(!$cities){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' City Not Found' : $message = 'المحافظة غير موجودة';
            return Helper::ResponseData(null,$message,false,404);
        }


        $branchData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
            'address_en' => $data['address_en'],
            'address_ar' => $data['address_ar'],
            'longitude' => $data['longitude'],
            'latitude' => $data['latitude'],
            'city_id' => $data['city_id'],
            'mobile' => $data['mobile']
        ];
        $this->branch->create($branchData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Add Branch Operation Success' : $message = 'نجحت عملية اضافة الفرع';

        return Helper::ResponseData(null,$message,true,200);


        

    }


    public function Update($data = []){ 

        $branch = $this->branch->where('uuid',$data['id'])->first();
        if(!$branch){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Branch Not Found' : $message = 'الفرع غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $cities = $this->cities->where('id',$data['city_id'])->first();
        if(!$cities){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' City Not Found' : $message = 'المحافظة غير موجودة';
            return Helper::ResponseData(null,$message,false,404);
        }


        $branchData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
            'address_en' => $data['address_en'],
            'address_ar' => $data['address_ar'],
            'longitude' => $data['longitude'],
            'latitude' => $data['latitude'],
            'city_id' => $data['city_id'],
            'mobile' => $data['mobile']
        ];
        $branch->update($branchData);
       

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Edit Branch Information Operation Success' : $message = 'نجحت عملية تعديل بيانات الفرع';

        return Helper::ResponseData(null,$message,true,200);


        

    }

   
    public function Delete($id){   
        
        $branch = $this->branch->where('uuid',$id)->first();
        if(!$branch){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Branch Not Found' : $message = 'الفرع غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }


        $branch->forceDelete();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Delete Branch Operation Success' : $message = 'نجحت عملية حذف الفرع';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    public function Active($id){   
        
        $branch = $this->branch->where('uuid',$id)->first();
        if(!$branch){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Branch Not Found' : $message = 'الفرع غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        if($branch->active == true){
            $branch->update([
                'active' => false
            ]);
            foreach ($branch->Admins as $admin) {
                $admin->update([
                    'active' => false
                ]);
            }

            foreach ($branch->Cars as $car) {
                $car->update([
                    'active' => false
                ]);
            }
        }
        else{
            $branch->update([
                'active' => true
            ]);
        }

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Change Branch Status Operation Success' : $message = 'نجحت عملية تعديل حالة الفرع';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    

                    
}