<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\ManagerInterface;
use App\Http\Resources\dashboard\AdminResource;
use App\Mail\InvitationsEmail;
use App\Models\Admin;
use App\Models\Avatar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ManagerRepo implements ManagerInterface
{
       
    public $manager;
    public $avatar;
    public function __construct()
    {
        $this->manager = new Admin();
        $this->avatar = new Avatar();
    }

    public function getAllManagers($search){
        
        $managers = $this->manager->where('role','Manager');
        if($search != null){
            $managers = $managers->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%')
                ->orWhere('gender',$search)
                ->orWhere('email',$search);
            });
            
        }
        $managers = $managers->latest()->paginate(10);
        $data = [
            'Managers' => AdminResource::collection($managers),
            'Pagination' => [
                'total'       => $managers->total(),
                'count'       => $managers->count(),
                'perPage'     => $managers->perPage(),
                'currentPage' => $managers->currentPage(),
                'totalPages'  => $managers->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Managers Operation Success' : $message = 'نجحت عملية الحصول علي كل المدراء ';

        return Helper::ResponseData($data,$message,true,200);
    }

    


    public function Add($data = []){ 
        
        
        if($data['image'] == null){
            $avatar = $this->avatar->where('gender',$data['gender'])->inRandomOrder()->first();
            $data['image'] = $avatar->image;
        } 
        $otp = random_int(100000, 999999);
        $managerData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
            'image' => $data['image'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'password' => Hash::make(Str::random(10)),
            'role' => 'Manager',
            'otp' => $otp
        ];
        $manager = $this->manager->create($managerData);
        $data = [
            'link' => "https://admin.asfarcogroup.com/verification?e=".Crypt::encryptString($manager->email),
            'email' => $manager->email
        ];
        Mail::to($data['email'])->send(new InvitationsEmail($data));
        

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Add Manager Operation Success' : $message = 'نجحت عملية اضافة مدير';

        return Helper::ResponseData(null,$message,true,200);


        

    }

    

    public function Delete($id){   
        
        $manager = $this->manager->where('uuid',$id)->first();
        if(!$manager){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Manager Not Found' : $message = 'مدير غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $manager->forceDelete();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Delete Manager Operation Success' : $message = 'نجحت عملية حذف المدير ';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    public function Active($id){   
        
        $manager = $this->manager->where('uuid',$id)->first();
        if(!$manager){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Manager Not Found' : $message = 'مدير غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        if($manager->active == true){
            $manager->update([
                'active' => false
            ]);
        }
        else{
            $manager->update([
                'active' => true
            ]);
        }

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Change Manager Status Operation Success' : $message = 'نجحت عملية تعديل حالة المدير';

        return Helper::ResponseData(null,$message,true,200);

        

    }
    

    

                    
}