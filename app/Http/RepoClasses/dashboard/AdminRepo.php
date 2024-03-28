<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\AdminInterface;
use App\Http\Resources\dashboard\AdminResource;
use App\Mail\InvitationsEmail;
use App\Models\Admin;
use App\Models\Avatar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AdminRepo implements AdminInterface
{
       
    public $admin;
    public $avatar;
    public function __construct()
    {
        $this->admin = new Admin();
        $this->avatar = new Avatar();
    }

    public function getAllAdmins($search){
        
        $admins = $this->admin->where('role','Admin');
        if($search != null){
            $admins = $admins->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%')
                ->orWhere('gender',$search)
                ->orWhere('email',$search);
            });
            
        }
        $admins = $admins->latest()->paginate(10);
        $data = [
            'Admins' => AdminResource::collection($admins),
            'Pagination' => [
                'total'       => $admins->total(),
                'count'       => $admins->count(),
                'perPage'     => $admins->perPage(),
                'currentPage' => $admins->currentPage(),
                'totalPages'  => $admins->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All System Administrators Operation Success' : $message = 'نجحت عملية الحصول علي كل مسؤولي النظام ';

        return Helper::ResponseData($data,$message,true,200);
    }

    


    public function Add($data = []){ 
        
        
        if($data['image'] == null){
            $avatar = $this->avatar->where('gender',$data['gender'])->inRandomOrder()->first();
            $data['image'] = $avatar->image;
        } 
        $adminData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
            'image' => $data['image'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'password' => Hash::make(Str::random(10)),
            'role' => 'Admin',
        ];
        $admin = $this->admin->create($adminData);
        
        $data = [
            'link' => "https://dashboard.asfarcogroup.com/verification?e=".Crypt::encryptString($admin->email),
            'email' => $admin->email
        ];
        Mail::to($data['email'])->send(new InvitationsEmail($data));

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Add System Administrator Operation Success' : $message = 'نجحت عملية اضافة مسؤل للنظام';

        return Helper::ResponseData(null,$message,true,200);


        

    }

   

    

                    
}