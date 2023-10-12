<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\UserInterface;
use App\Http\Resources\dashboard\UserResource;
use App\Models\User;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Database\Eloquent\Builder;


class UserRepo implements UserInterface
{
       
    public $user;
    public function __construct()
    {
        $this->user = new User();
    }

    public function getAllPendingUsers($search){
        
        $users = $this->user->where('verify_document',false)->where('verify_document_at','==',null)->where('email_verified_at','!=',null)->where('Verify_at','!=',null);
        if($search != null){
            $users = $users->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%')
                ->orWhere('email',$search);
            });
            
        }
        $users = $users->latest()->paginate(10);
        $data = [
            'Users' => UserResource::collection($users),
            'Pagination' => [
                'total'       => $users->total(),
                'count'       => $users->count(),
                'perPage'     => $users->perPage(),
                'currentPage' => $users->currentPage(),
                'totalPages'  => $users->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Users Operation Success' : $message = 'نجحت عملية الحصول علي كل مستخدمي النظام ';

        return Helper::ResponseData($data,$message,true,200);
    }

    public function getAllDeactiveUsers($search){
        
        $users = $this->user->where('active',false)->where('email_verified_at','!=',null)->where('Verify_at','!=',null)->where('verify_document',true)->where('verify_document_at','!=',null);
        if($search != null){
            $users = $users->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%')
                ->orWhere('email',$search);
            });
            
        }
        $users = $users->latest()->paginate(10);
        $data = [
            'Users' => UserResource::collection($users),
            'Pagination' => [
                'total'       => $users->total(),
                'count'       => $users->count(),
                'perPage'     => $users->perPage(),
                'currentPage' => $users->currentPage(),
                'totalPages'  => $users->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Users Operation Success' : $message = 'نجحت عملية الحصول علي كل مستخدمي النظام ';

        return Helper::ResponseData($data,$message,true,200);
    }

    public function getAllUnVerificationsUsers($search){
        
        $users = $this->user->where('email_verified_at','==',null)->where('Verify_at','==',null)->where('verify_document',false)->where('verify_document_at','==',null);
        if($search != null){
            $users = $users->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%')
                ->orWhere('email',$search);
            });
            
        }
        $users = $users->latest()->paginate(10);
        $data = [
            'Users' => UserResource::collection($users),
            'Pagination' => [
                'total'       => $users->total(),
                'count'       => $users->count(),
                'perPage'     => $users->perPage(),
                'currentPage' => $users->currentPage(),
                'totalPages'  => $users->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Users Operation Success' : $message = 'نجحت عملية الحصول علي كل مستخدمي النظام ';

        return Helper::ResponseData($data,$message,true,200);
    }

    public function getAllActiveUsers($search){
        
        $users = $this->user->where('active',true)->where('email_verified_at','!=',null)->where('Verify_at','!=',null)->where('verify_document',true)->where('verify_document_at','!=',null);
        if($search != null){
            $users = $users->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%')
                ->orWhere('email',$search);
            });
            
        }
        $users = $users->latest()->paginate(10);
        $data = [
            'Users' => UserResource::collection($users),
            'Pagination' => [
                'total'       => $users->total(),
                'count'       => $users->count(),
                'perPage'     => $users->perPage(),
                'currentPage' => $users->currentPage(),
                'totalPages'  => $users->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Users Operation Success' : $message = 'نجحت عملية الحصول علي كل مستخدمي النظام ';

        return Helper::ResponseData($data,$message,true,200);
    }


    public function Active($id){   
        
        $user = $this->user->where('uuid',$id)->first();
        if(!$user){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'User Not Found' : $message = 'مستخدم غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        if($user->active == true){
            $user->update([
                'active' => false
            ]);
        }
        else{
            $user->update([
                'active' => true
            ]);
        }

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Change Manager Status Operation Success' : $message = 'نجحت عملية تعديل حالة المستخدم';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    public function VerifyDocument($id){   
        
        $user = $this->user->where('uuid',$id)->first();
        if(!$user){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'User Not Found' : $message = 'مستخدم غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        $user->update([
            'verify_document' => true,
            'verify_document_at' => Carbon::now(new DateTimeZone('Asia/Dubai')),
        ]);

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Verify User Operation Success' : $message = 'نجحت عملية التحقق من المستخدم';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    public function ViewDocument($id){   
        
        $user = $this->user->where('uuid',$id)->first();
        if(!$user){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'User Not Found' : $message = 'مستخدم غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'View User Document Operation Success' : $message = 'نجحت عملية عرض مستند المستخدم';

        return Helper::ResponseData([
            'id' => $this->user,
            'document' => $user->document,
        ],$message,true,200);

        

    }
   

    

                    
}