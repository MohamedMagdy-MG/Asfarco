<?php
        
namespace App\Http\RepoClasses\dashboard;

use App\Helpers\Helper;
use App\Http\RepoInterfaces\dashboard\BranchEmployeeInterface;
use App\Http\Resources\dashboard\BranchCustomResource;
use App\Http\Resources\dashboard\BranchEmployeeResource;
use App\Mail\InvitationsEmail;
use App\Models\Admin;
use App\Models\Avatar;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class BranchEmployeeRepo implements BranchEmployeeInterface
{
       
    public $branchEmployee;
    public $branch;
    public $avatar;
    public function __construct()
    {
        $this->branchEmployee = new Admin();
        $this->branch = new Branch();
        $this->avatar = new Avatar();
    }

    public function getAllBranchEmployees($search,$branch){
        
        $branchEmployees = $this->branchEmployee->where('role','Branch Employee');
        if($branch != null){
            $branchEmployees = $branchEmployees->where(function(Builder $query) use($branch){
                $query->whereHas('Branch',function(Builder $query) use($branch){
                    $query->where('uuid',$branch);
                });
               
            });
            
        }
        if($search != null){
            $branchEmployees = $branchEmployees->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%')
                ->orWhere('gender',$search)
                ->orWhere('email',$search);
            });
            
        }
        
        $branchEmployees = $branchEmployees->latest()->paginate(10);
        $data = [
            'BranchEmployees' => BranchEmployeeResource::collection($branchEmployees),
            'Pagination' => [
                'total'       => $branchEmployees->total(),
                'count'       => $branchEmployees->count(),
                'perPage'     => $branchEmployees->perPage(),
                'currentPage' => $branchEmployees->currentPage(),
                'totalPages'  => $branchEmployees->lastPage()
            ]
        ];
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Branch Employees Operation Success' : $message = 'نجحت عملية الحصول علي كل موظفين الفروع ';

        return Helper::ResponseData($data,$message,true,200);
    }

    public function getAllBranches($search){
        
        $branches = $this->branch;
        
        if($search != null){
            $branches = $branches->where(function(Builder $query) use($search){
                $query->where('name_en','LIKE','%'.$search.'%')
                ->orWhere('name_ar','LIKE','%'.$search.'%')
                ->orWhere('gender',$search)
                ->orWhere('email',$search);
            });
            
        }
        
        $branches = $branches->latest()->get();
        
        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Get All Branches Operation Success' : $message = 'نجحت عملية الحصول علي كل الفروع ';

        return Helper::ResponseData(BranchCustomResource::collection($branches),$message,true,200);
    }

    public function Add($data = []){ 
        
        $branch = $this->branch->where('uuid',$data['branch'])->first();
        if(!$branch){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = 'Branch Not Found' : $message = 'فرع غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }
        
        if($data['image'] == null){
            $avatar = $this->avatar->where('gender',$data['gender'])->inRandomOrder()->first();
            $data['image'] = $avatar->image;
        } 
        $branchEmployeeData = [
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
            'image' => $data['image'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'password' => Hash::make(Str::random(10)),
            'role' => 'Branch Employee',
            'branch_id' => $data['branch']
        ];
        $branchEmployee = $this->branchEmployee->create($branchEmployeeData);
        
        $data = [
            'link' => "https://admin.asfarcogroup.com/verification?e=".Crypt::encryptString($branchEmployee->email),
            'email' => $branchEmployee->email
        ];
        Mail::to($data['email'])->send(new InvitationsEmail($data));
        
        

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Add  Branch Employee Operation Success' : $message = 'نجحت عملية اضافة موظف للفرع';

        return Helper::ResponseData(null,$message,true,200);


        

    }

   
    public function Delete($id){   
        
        $branchEmployee = $this->branchEmployee->where('uuid',$id)->first();
        if(!$branchEmployee){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Branch Employee Not Found' : $message = 'موظف الفرع غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }


        $branchEmployee->forceDelete();

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Delete  Branch Employee Operation Success' : $message = 'نجحت عملية حذف موظف الفرع';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    public function Active($id){   
        
        $branchEmployee = $this->branchEmployee->where('uuid',$id)->first();
        if(!$branchEmployee){
            request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
            $language == 'en' ? $message = ' Branch Employee Not Found' : $message = 'موظف الفرع غير موجود';
            return Helper::ResponseData(null,$message,false,404);
        }

        if($branchEmployee->active == true){
            $branchEmployee->update([
                'active' => false
            ]);
        }
        else{
            if($branchEmployee->Branch->active == false){
                request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
                $language == 'en' ? $message = 'Employee branch is inactive' : $message = 'فرع الموظف غير نشط';
                return Helper::ResponseData(null,$message,false,400);
            }
            $branchEmployee->update([
                'active' => true
            ]);
        }

        request()->headers->has('language') ? $language = request()->headers->get('language') : $language = 'en';
        $language == 'en' ? $message = 'Change Branch Employee Status Operation Success' : $message = 'نجحت عملية تعديل حالة موظف الفرع';

        return Helper::ResponseData(null,$message,true,200);

        

    }

    

                    
}